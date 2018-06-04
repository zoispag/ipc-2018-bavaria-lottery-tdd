<?php

use PHPUnit\Framework\TestCase;

class BavariaLotteryTest extends TestCase
{
	public function test_lottery_consists_of_1000_tickets()
	{
		$lottery = new BavariaLottery;
		$this->assertCount(1000, $lottery->batch);
		$this->assertInstanceOf('LotteryTicket', $lottery->batch[0]);
		$this->assertInstanceOf('LotteryTicket', $lottery->batch[999]);
	}

	public function test_lottery_consists_of_1000_unique_tickets()
	{
		$lottery = new BavariaLottery;
		$this->assertSame(array_column($lottery->batch, 'uid'), array_unique(array_column($lottery->batch, 'uid')));
		$this->assertEquals(1000, count(array_unique(array_column($lottery->batch, 'uid'))));
	}

	public function test_lottery_total_sales_are_1000_euro()
	{
		$lottery = new BavariaLottery;
		$this->assertEquals(1000, $lottery->total_sales);
	}

	public function test_lottery_pays_at_least_95_percent_of_all_bets()
	{
		$lottery = new BavariaLottery;
		$this->assertGreaterThanOrEqual(0.95, $lottery->getPayOutPercentage());
	}

	public function test_lottery_pays_at_most_96_percent_of_all_bets()
	{
		$lottery = new BavariaLottery;
		$this->assertLessThanOrEqual(0.96, $lottery->getPayOutPercentage());
	}

	public function test_losses_are_more_than_all_the_wins_combined()
	{
		$lottery = new BavariaLottery;
		// var_dump($lottery->getAllocation(), $lottery->getPayOutPercentage());
		$this->assertGreaterThan($lottery->getAllocatedWins(), $lottery->getAllocatedLoses());
	}

}
