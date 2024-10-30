<?php
namespace Bookmify;



// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {exit; }


/**
 * Class HelperTime
 */
class HelperTime
{
	/**
     * Get Timezone
	 * @since 1.0.0
     */
	public static function getTimeZone()
    {
		
		$timezoneString 	= get_option('timezone_string');
		$gmtOffset 			= get_option('gmt_offset');

		if ($timezoneString) {
			$timezone = new \DateTimeZone($timezoneString);
		} elseif ($gmtOffset) {
			$hours = (int)$gmtOffset;
			$minutes = ($gmtOffset - floor($gmtOffset)) * 60;

			$timezone = new \DateTimeZone(sprintf('%+03d:%02d', $hours, $minutes));
		} else {
			$timezone = new \DateTimeZone('UTC');
		}
		return $timezone;
    }

    /**
     * Get Current DateTime
	 * @since 1.0.0
     */
    public static function getCurrentDateTime()
    {
		$dateTimeObject = new \DateTime('now', self::getTimeZone());
        return $dateTimeObject->format('Y-m-d H:i:s');
    }
    /**
     * Get Current DateTime
	 * @since 1.0.0
     */
    public static function getCurrentDateTimePlus($sec = 10)
    {
		$dateTimeObject = new \DateTime('now', self::getTimeZone());
		$dateTimeObject->add(new \DateInterval('PT'.$sec.'S'));
        return $dateTimeObject->format('Y-m-d H:i:s');
    }
	
	public static function getDateTimeRFC3339($datetime)
    {
        $dateTimeObject = new \DateTime($datetime, self::getTimeZone());
        $dateTimeObject->setTimezone(new \DateTimeZone('UTC'));
        return $dateTimeObject->format(DATE_RFC3339);
    }
	
	public static function getCustomDateTime($datetime)
    {
        $dateTimeObject = new \DateTime($datetime, self::getTimeZone());
        return $dateTimeObject;
    }
	
	 public static function getCurrentDateTimeWithoutFormat()
    {
		$dateTimeObject = new \DateTime('now', self::getTimeZone());
        return $dateTimeObject;
    }
	public static function getCurrentDateTimePlusWithoutFormat($sec = 10)
    {
		$dateTimeObject = new \DateTime('now', self::getTimeZone());
		$dateTimeObject->add(new \DateInterval('PT'.$sec.'S'));
        return $dateTimeObject;
    }
}

