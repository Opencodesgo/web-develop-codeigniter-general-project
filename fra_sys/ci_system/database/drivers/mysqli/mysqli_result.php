<?php
/**
 * 系统，数据库，mysqli，mysqli 结果
 */

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.3.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MySQLi Result Class
 * MySQLi结果类。
 *
 * This class extends the parent result class: CI_DB_result
 *
 * @package		CodeIgniter
 * @subpackage	Drivers
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/database/
 */
class CI_DB_mysqli_result extends CI_DB_result {

	/**
	 * Number of rows in the result set
	 * 结果集中的行数
	 *
	 * @return	int
	 */
	public function num_rows()
	{
		return is_int($this->num_rows)
			? $this->num_rows
			: $this->num_rows = $this->result_id->num_rows;
	}

	// --------------------------------------------------------------------

	/**
	 * Number of fields in the result set
	 * 结果集中的字段数
	 *
	 * @return	int
	 */
	public function num_fields()
	{
		return $this->result_id->field_count;
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch Field Names
	 * 获取字段名称。
	 *
	 * Generates an array of column names
	 *
	 * @return	array
	 */
	public function list_fields()
	{
		$field_names = array();
		$this->result_id->field_seek(0);
		while ($field = $this->result_id->fetch_field())
		{
			$field_names[] = $field->name;
		}

		return $field_names;
	}

	// --------------------------------------------------------------------

	/**
	 * Field data
	 * 现场数据。
	 *
	 * Generates an array of objects containing field meta-data
	 * 生成包含字段元数据的对象数组。
	 *
	 * @return	array
	 */
	public function field_data()
	{
		$retval = array();
		$field_data = $this->result_id->fetch_fields();
		for ($i = 0, $c = count($field_data); $i < $c; $i++)
		{
			$retval[$i]			= new stdClass();
			$retval[$i]->name		= $field_data[$i]->name;
			$retval[$i]->type		= static::_get_field_type($field_data[$i]->type);
			$retval[$i]->max_length		= $field_data[$i]->max_length;
			$retval[$i]->primary_key	= (int) ($field_data[$i]->flags & MYSQLI_PRI_KEY_FLAG);
			$retval[$i]->default		= $field_data[$i]->def;
		}

		return $retval;
	}

	// --------------------------------------------------------------------

	/**
	 * Get field type
	 * 获取字段类型。
	 *
	 * Extracts field type info from the bitflags returned by
	 * mysqli_result::fetch_fields()
	 *
	 * @used-by	CI_DB_mysqli_result::field_data()
	 * @param	int	$type
	 * @return	string
	 */
	private static function _get_field_type($type)
	{
		static $map;
		isset($map) OR $map = array(
			MYSQLI_TYPE_DECIMAL     => 'decimal',
			MYSQLI_TYPE_BIT         => 'bit',
			MYSQLI_TYPE_TINY        => 'tinyint',
			MYSQLI_TYPE_SHORT       => 'smallint',
			MYSQLI_TYPE_INT24       => 'mediumint',
			MYSQLI_TYPE_LONG        => 'int',
			MYSQLI_TYPE_LONGLONG    => 'bigint',
			MYSQLI_TYPE_FLOAT       => 'float',
			MYSQLI_TYPE_DOUBLE      => 'double',
			MYSQLI_TYPE_TIMESTAMP   => 'timestamp',
			MYSQLI_TYPE_DATE        => 'date',
			MYSQLI_TYPE_TIME        => 'time',
			MYSQLI_TYPE_DATETIME    => 'datetime',
			MYSQLI_TYPE_YEAR        => 'year',
			MYSQLI_TYPE_NEWDATE     => 'date',
			MYSQLI_TYPE_INTERVAL    => 'interval',
			MYSQLI_TYPE_ENUM        => 'enum',
			MYSQLI_TYPE_SET         => 'set',
			MYSQLI_TYPE_TINY_BLOB   => 'tinyblob',
			MYSQLI_TYPE_MEDIUM_BLOB => 'mediumblob',
			MYSQLI_TYPE_BLOB        => 'blob',
			MYSQLI_TYPE_LONG_BLOB   => 'longblob',
			MYSQLI_TYPE_STRING      => 'char',
			MYSQLI_TYPE_VAR_STRING  => 'varchar',
			MYSQLI_TYPE_GEOMETRY    => 'geometry'
		);

		return isset($map[$type]) ? $map[$type] : $type;
	}

	// --------------------------------------------------------------------

	/**
	 * Free the result
	 * 释放结果
	 *
	 * @return	void
	 */
	public function free_result()
	{
		if (is_object($this->result_id))
		{
			$this->result_id->free();
			$this->result_id = FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Data Seek
	 * 数据查找。
	 *
	 * Moves the internal pointer to the desired offset. We call
	 * this internally before fetching results to make sure the
	 * result set starts at zero.
	 * 将内部指针移动到指定偏移量。我们在获取结果前会调用此方法，以确保结果集从零开始。
	 *
	 * @param	int	$n
	 * @return	bool
	 */
	public function data_seek($n = 0)
	{
		return $this->result_id->data_seek($n);
	}

	// --------------------------------------------------------------------

	/**
	 * Result - associative array
	 * 结果-关联的数组。
	 *
	 * Returns the result set as an array
	 * 将结果集返回为一个数组。
	 *
	 * @return	array
	 */
	protected function _fetch_assoc()
	{
		return $this->result_id->fetch_assoc();
	}

	// --------------------------------------------------------------------

	/**
	 * Result - object
	 *
	 * Returns the result set as an object
	 *
	 * @param	string	$class_name
	 * @return	object
	 */
	protected function _fetch_object($class_name = 'stdClass')
	{
		return $this->result_id->fetch_object($class_name);
	}

}
