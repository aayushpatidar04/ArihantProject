<?php

namespace App\Services;

class CalendarLinkService
{
    public static function generateIcs(
        string $title,
        string $start,      // e.g. '2026-09-05 10:00:00'
        string $end,        // e.g. '2026-09-05 17:00:00'
        string $location,
        string $description,
        string $uid = null
    ): string {
        $uid = $uid ?? uniqid('arihant_', true) . '@arihantcapital.com';
        $dtStart = gmdate('Ymd\\THis\\Z', strtotime($start));
        $dtEnd   = gmdate('Ymd\\THis\\Z', strtotime($end));
        $dtStamp = gmdate('Ymd\\THis\\Z');

        $description = str_replace(["\r\n", "\n", "\r"], "\\n", strip_tags($description));
        $location    = str_replace(["\r\n", "\n", "\r"], ", ", $location);

        return <<<ICS
            BEGIN:VCALENDAR
            VERSION:2.0
            PRODID:-//Arihant Capital//ArihantPLUS Conclave//EN
            CALSCALE:GREGORIAN
            METHOD:PUBLISH
            BEGIN:VEVENT
            UID:{$uid}
            DTSTAMP:{$dtStamp}
            DTSTART:{$dtStart}
            DTEND:{$dtEnd}
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
        $dates = gmdate('Ymd\\THis\\Z', strtotime($start)) . '/' . gmdate('Ymd\\THis\\Z', strtotime($end));
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
        return 'https://outlook.live.com/calendar/0/deeplink/compose'
            . '?subject=' . urlencode($title)
            . '&startdt=' . urlencode($start)
            . '&enddt=' . urlencode($end)
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
        return 'https://calendar.yahoo.com/?v=60&view=d&type=20'
            . '&title=' . urlencode($title)
            . '&st=' . gmdate('Ymd\\THis\\Z', strtotime($start))
            . '&et=' . gmdate('Ymd\\THis\\Z', strtotime($end))
            . '&desc=' . urlencode(strip_tags($description))
            . '&in_loc=' . urlencode($location);
    }
}