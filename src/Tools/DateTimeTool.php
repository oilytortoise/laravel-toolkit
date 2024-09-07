<?php

namespace Oilytortoise\LaravelToolkit\Tools;

use DateTime;
use DateTimeZone;

/**
 * A tool for manipulating dates to your will.
 * Carbon is incredibly powerful, however it can take a huge toll
 * on performance when many records are being looped through
 * so this tool attempts to provide some of the very simple
 * functions without using Carbon.
 * 
 * @author Oilytortoise
 */
class DateTimeTool
{
    public function __construct(protected string $datetime) {}

    /**
     * A static constructor "factory" because `DateTimeTool::date($date)`
     * just feels nicer to me than `new DateTimeTool($date)
     */
    public static function date(string $datetime)
    {
        return new self($datetime);
    }

    /**
     * Set the date.
     */
    public function setDate(string $datetime): void
    {
        $this->datetime = $datetime;
    }

    /**
     * Get the date.
     */
    public function get()
    {
        return $this->datetime;
    }

    /**
     * Convert the datetime string into a provided format and timezone
     * default format = "September 7th, 2024"
     */
    public function convertForHumans(string $format = 'F jS, Y', ?string $to = null): string
    {
        $to = new DateTimeZone($to ?? date_default_timezone_get());
        $datetime = new DateTime($this->datetime, $to);

        return $datetime->format($format);
    }

    /**
     * Convert a given datetime to or from the server timezone.
     */
    public function convertTimezone(string $to = null, string $from = null)
    {
        $from = $from ?? date_default_timezone_get();
        $to = $to ?? date_default_timezone_get();

        $dt = new DateTime($this->datetime, new DateTimeZone($from));
        $dt->setTimezone(new DateTimeZone($to));

        return $dt->format("Y-m-d H:i:s");
    }
}