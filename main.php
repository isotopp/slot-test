#! /usr/bin/env php
<?php
class StaticTest {
	public $a_key_with_a_very_long_name_00;
	public $a_key_with_a_very_long_name_01;
	public $a_key_with_a_very_long_name_02;
	public $a_key_with_a_very_long_name_03;
	public $a_key_with_a_very_long_name_04;
	public $a_key_with_a_very_long_name_05;
	public $a_key_with_a_very_long_name_06;
	public $a_key_with_a_very_long_name_07;
	public $a_key_with_a_very_long_name_08;
	public $a_key_with_a_very_long_name_09;

	public $a_key_with_a_very_long_name_10;
	public $a_key_with_a_very_long_name_11;
	public $a_key_with_a_very_long_name_12;
	public $a_key_with_a_very_long_name_13;
	public $a_key_with_a_very_long_name_14;
	public $a_key_with_a_very_long_name_15;
	public $a_key_with_a_very_long_name_16;
	public $a_key_with_a_very_long_name_17;
	public $a_key_with_a_very_long_name_18;
	public $a_key_with_a_very_long_name_19;

    public function __construct() {
		$this->a_key_with_a_very_long_name_00 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_01 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_02 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_03 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_04 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_05 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_06 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_07 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_08 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_09 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_10 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_11 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_12 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_13 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_14 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_15 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_16 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_17 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_18 = $this->randomString(20);
		$this->a_key_with_a_very_long_name_19 = $this->randomString(20);
    }

    private function randomString($length) {
        $abc = 'abcdefghijklmnopqrstuvwxyz';
        $l = strlen($abc);
        for ($res = '', $i = 0; $i < $length; $i++) {
            $res .= $abc[rand(0, $l - 1)];
        }
        return $res;
    }
}

#[AllowDynamicProperties]
class DynamicTest {

    public function __construct() {
		for ($i = 0; $i < 20; $i++) {
			$this->{"a_key_with_a_very_long_name_$i"} = $this->randomString(20);
		}
    }

    private function randomString($length) {
        $abc = 'abcdefghijklmnopqrstuvwxyz';
        $l = strlen($abc);
        for ($res = '', $i = 0; $i < $length; $i++) {
            $res .= $abc[rand(0, $l - 1)];
        }
        return $res;
    }
}

$n = 1000000;
$objects = [];

$mem_start = memory_get_usage();
$time_start = microtime(TRUE);
for ($i = 0; $i < $n; $i++) {
    $objects[] = new StaticTest();
}
$time_end = microtime(TRUE);
$mem_end = memory_get_usage();

$mem_delta = $mem_end - $mem_start;
$mem_delta = $mem_delta/$n;
$time_delta = $time_end - $time_start;

echo "Time: $time_delta\n";
echo "Memory: $mem_delta\n";
echo;

#### 

$objects = [];

$mem_start = memory_get_usage();
$time_start = microtime(TRUE);

for ($i = 0; $i < $n; $i++) {
    $objects[] = new DynamicTest();
}

$time_end = microtime(TRUE);
$mem_end = memory_get_usage();

$mem_delta = $mem_end - $mem_start;
$mem_delta = $mem_delta/$n;
$time_delta = $time_end - $time_start;

echo "Time: $time_delta\n";
echo "Memory: $mem_delta\n";
echo;
