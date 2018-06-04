<?php

class LotteryTicket
{
	const WINNING_DEGREE_NO_WIN = 0;
	const WINNING_DEGREE_1_EUR  = 1;
	const WINNING_DEGREE_2_EUR  = 2;
	const WINNING_DEGREE_10_EUR = 10;

	public $uid = null;
	public $winning_degree = WINNING_DEGREE_NO_WIN;
	public $price = 1; // EUR

	public function __construct()
	{
		$this->uid = uniqid();
	}
}