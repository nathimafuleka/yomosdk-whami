<?php

namespace Yomo7\Whami;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Collection;
use ReflectionMethod;

class WhamiKeywordSubscriber
{
    /** @var string */
    protected static string $channel;

    /** @var Collection|null */
    protected static ?Collection $keywordHandlers = null;

    /** @var Collection|null */
    protected static ?Collection $events = null;

    /**
     * Boots Whami against a specific YOMO Channel
     * @param string $channel
     */
    public static function boot(string $channel)
    {
        $channel = strtolower($channel);
        self::$channel = $channel;

        // Register the channel-specific keywords
        collect(config("whami.keywords.$channel"))->each(function (string $handler) {
            self::register($handler);
        });
        
        // Register global keywords
        collect(config("whami.keywords.global"))->each(function (string $handler) {
            self::register($handler);
        });
    }

    /**
     * Register a Whami handler class so that it can start listening for Keyword Events
     * @param string $class The fully-qualified class name to be registered
     */
    public static function register(string $class)
    {
        if (empty(self::$events)) {
            self::$events = collect();
        }

        if (empty(self::$keywordHandlers)) {
            self::$keywordHandlers = collect();
        }

        self::$keywordHandlers->put($class, $class);
    }

    /**
     * Returns whether a Keyword handler for a specified event exists or not
     *
     * @param string $name
     *
     * @return bool
     */
    public static function keywordHandlerExists(string $name): bool
    {
        if (self::$events) {
            return self::$events->get($name, false) != false;
        } else return false;
    }

    /**
     * Subscribes an event to an event Dispatcher
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        if (!empty(self::$keywordHandlers)) {
            foreach (self::$keywordHandlers as $name => $class) {
                $reflection = new \ReflectionClass($class);
                if ($reflection->isSubclassOf(Whami::class)
                    && $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC)) {
                    foreach ($methods as $method) {
                        if (strpos($method->name, 'event') === 0) {
                            $event_name = preg_replace('/^event/i', '', $method->name);
                            $this->registerEvent($events, $event_name, $class . '@' . $method->name);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param \Illuminate\Events\Dispatcher $events
     * @param                               $name
     * @param                               $method
     */
    protected function registerEvent(Dispatcher $events, $name, $method)
    {
        $events->listen($name, $method);
        self::$events->put($name, $method);
    }
}
