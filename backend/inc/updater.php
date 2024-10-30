<?php
namespace Bookmify;



// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {exit; }


/**
 * Class Helper
 */
class Updater
{
	
	/**
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct(){
		$this -> updateTables();
	}
	
	
	/**
     * Alter Tables.
	 * @since 1.0.0
     */
    public function updateTables()
    {
		global $wpdb;
		
		$this->addColumnsQuery(array(
//				array(
//					'tablename' 	=> $wpdb->prefix.'bmify_customers',
//					'columnname' 	=> 'gender',
//					'query' 		=> 'ALTER TABLE `%s` ADD COLUMN `%s` ENUM("male","female") DEFAULT NULL AFTER `phone`', 
//				),
				array(
					'tablename' 	=> $wpdb->prefix.'bmify_appointments',
					'columnname' 	=> 'google_calendar_event_id',
					'query' 		=> 'ALTER TABLE `%s` ADD COLUMN `%s` VARCHAR(255) DEFAULT NULL AFTER `position`', 
				),
			)
		);
		
		
//		$this->dropColumnsQuery(array(
//			array(
//				'tablename' 	=> $wpdb->prefix.'bmify_customers',
//				'columnname' 	=> 'gender',
//				'query' 		=> 'ALTER TABLE `%s` DROP COLUMN `%s`',
//			),
//		));
		
		
    }
	
	
	/**
	 * @since 1.0.0
	 * @access private
	 */
	private function columnExists( $table_name, $column_name )
    {
        global $wpdb;
		// check if column name exists or not
		$table_name 	= esc_sql($table_name);
		$column_name 	= esc_sql($column_name);
        $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$table_name}' AND column_name = '{$column_name}'" );
		
		return $row;
    }
	
	
  	/**
	 * @since 1.0.0
	 * @access private
	 */
    private function addColumnsQuery( array $data )
    {
        global $wpdb;
		
		foreach ( $data as $item ) {
			
			$column_name = $this->columnExists($item['tablename'], $item['columnname']);
			
			if(empty($column_name)){
				$wpdb->query( sprintf( $item['query'], $item['tablename'], $item['columnname'] ) );
			}

		}   
    }
	
	
	/**
	 * @since 1.0.0
	 * @access private
	 */
    private function dropColumnsQuery( array $data )
    {
        global $wpdb;
		
		foreach ( $data as $item ) {
			
			$column_name = $this->columnExists($item['tablename'], $item['columnname']);
			
			if(!empty($column_name)){
				$wpdb->query( sprintf( $item['query'], $item['tablename'], $item['columnname'] ) );
			}

		}   
    }

    
}

