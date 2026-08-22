<?php

namespace App\Services;

class CalendarLinkService
{
    protected static string $tz = 'Asia/Kolkata';

    public static function generateIcs(
        string $title,
        string $start,      // e.g. '2026-09-05 10:00:00'  (IST)
        string $end,        // e.g. '2026-09-05 17:00:00'  (IST)
        string $location,
        string $description,
        string $uid = null
    ): string {
        $uid = $uid ?? uniqid('arihant_', true) . '@arihantcapital.com';
        $dtStamp = gmdate('Ymd\\THis\\Z');

        // Parse as IST so there is never any server-timezone ambiguity
        $tz = new \DateTimeZone(self::$tz);
        $dtStart = (new \DateTime($start, $tz))->format('Ymd\\THis');
        $dtEnd   = (new \DateTime($end, $tz))->format('Ymd\\THis');

        $description = str_replace(["\r\n", "\n", "\r"], "\\n", strip_tags($description));
        $location    = str_replace(["\r\n", "\n", "\r"], ", ", $location);

        // Heredoc lines must start at column 0 — do not indent
        return <<<ICS
            BEGIN:VCALENDAR
            VERSION:2.0
            PRODID:-//Arihant Capital//ArihantPLUS Conclave//EN
            CALSCALE:GREGORIAN
            METHOD:PUBLISH
            BEGIN:VTIMEZONE
            TZID:Asia/Kolkata
            BEGIN:STANDARD
            DTSTART:19700101T000000
            TZOFFSETFROM:+0530
            TZOFFSETTO:+0530
            END:STANDARD
            END:VTIMEZONE
            BEGIN:VEVENT
            UID:{$uid}
            DTSTAMP:{$dtStamp}
            DTSTART;TZID=Asia/Kolkata:{$dtStart}
            DTEND;TZID=Asia/Kolkata:{$dtEnd}
            SUMMARY:{$title}
            DESCRIPTION:{$description}
            LOCATION:{$location}
            STATUS:CONFIRMED
            SEQUENCE:0
            BEGIN:VALARM
            ACTION:DISPLAY
            DESCRIPTION:Reminder
            TRIGGER:-PT1H
            END:VALARM
            END:VEVENT
            END:VCALENDAR
            ICS;
    }

    public static function google(
        string $title,
        string $start,
        string $end,
        string $location,
        string $description
    ): string {
        $tz = new \DateTimeZone(self::$tz);

        $s = (new \DateTime($start, $tz))->setTimezone(new \DateTimeZone('UTC'));
        $e = (new \DateTime($end, $tz))->setTimezone(new \DateTimeZone('UTC'));

        $dates = $s->format('Ymd\\THis\\Z') . '/' . $e->format('Ymd\\THis\\Z');

        return 'https://calendar.google.com/calendar/render?action=TEMPLATE'
            . '&text=' . urlencode($title)
            . '&dates=' . $dates
            . '&details=' . urlencode(strip_tags($description))
            . '&location=' . urlencode($location);
    }

    public static function outlook(
        string $title,
        string $start,
        string $end,
        string $location,
        string $description
    ): string {
        $tz = new \DateTimeZone(self::$tz);

        // Outlook Web likes ISO 8601 with explicit offset
        $s = (new \DateTime($start, $tz))->format('Y-m-d\\TH:i:s');
        $e = (new \DateTime($end, $tz))->format('Y-m-d\\TH:i:s');

        return 'https://outlook.live.com/calendar/0/deeplink/compose'
            . '?subject=' . urlencode($title)
            . '&startdt=' . urlencode($s)
            . '&enddt=' . urlencode($e)
            . '&body=' . urlencode(strip_tags($description))
            . '&location=' . urlencode($location);
    }

    public static function yahoo(
        string $title,
        string $start,
        string $end,
        string $location,
        string $description
    ): string {
        $tz = new \DateTimeZone(self::$tz);

        $s = (new \DateTime($start, $tz))->format('Ymd\\THis\\Z');
        $e = (new \DateTime($end, $tz))->format('Ymd\\THis\\Z');

        return 'https://calendar.yahoo.com/?v=60&view=d&type=20'
            . '&title=' . urlencode($title)
            . '&st=' . $s
            . '&et=' . $e
            . '&desc=' . urlencode(strip_tags($description))
            . '&in_loc=' . urlencode($location);
    }
}