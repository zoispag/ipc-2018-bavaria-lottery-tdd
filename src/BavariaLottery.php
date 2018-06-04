<?php

class BavariaLottery
{
	const TOTAL_TICKETS = 1000;
	const RATIO = 0.95; // The laws require the lottery to pay out at least 95% of all bets

	public $batch = [];
	public $total_sales = 0;
	public $total_pays = 0;

	private $accounted = 0;

	private $allocation = [
		LotteryTicket::WINNING_DEGREE_NO_WIN => 0,
		LotteryTicket::WINNING_DEGREE_1_EUR  => 0,
		LotteryTicket::WINNING_DEGREE_2_EUR  => 0,
		LotteryTicket::WINNING_DEGREE_10_EUR => 0
	];

	public function __construct()
	{
		foreach (range(0, self::TOTAL_TICKETS - 1) as $i) {
			$this->batch[$i] = new LotteryTicket;
			$this->total_sales += $this->batch[$i]->price;

			$degree = $this->allocate_winning_degree();
			$this->allocation[$degree]++;
			$this->total_pays += $this->batch[$i]->winning_degree = $degree;

			$this->accounted++;
		}
	}

	public function getPayOutPercentage()
	{
		return $this->total_pays / $this->total_sales;
	}

	public function allocate_winning_degree()
	{
		if (($this->getPayOutPercentage() < self::RATIO)) {
			switch (rand(0, 2)) {
				case 0:
					return LotteryTicket::WINNING_DEGREE_10_EUR;
				case 1:
					return LotteryTicket::WINNING_DEGREE_2_EUR;
				case 2:
					return LotteryTicket::WINNING_DEGREE_1_EUR;
			}
		}
		return LotteryTicket::WINNING_DEGREE_NO_WIN;
	}

	public function getAllocatedWins()
	{
		return  $this->allocation[LotteryTicket::WINNING_DEGREE_1_EUR] +
				$this->allocation[LotteryTicket::WINNING_DEGREE_2_EUR] +
				$this->allocation[LotteryTicket::WINNING_DEGREE_10_EUR];
	}

	public function getAllocatedLoses()
	{
		return $this->allocation[LotteryTicket::WINNING_DEGREE_NO_WIN];
	}

	public function getAllocation()
	{
		return $this->allocation;
	}
}