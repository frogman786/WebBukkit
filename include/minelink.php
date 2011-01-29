<?php

class MineLink
{
	var $socket;

	public function __construct()
	{
		require('../config.php');

		$this->socket = stream_socket_client($minelink['server'] . ':' . $minelink['port'], $erno, $erst, 5);

		if(!$this->socket)
			die('<div id="PageContent"><div class="Notice">Error: ' . $erst . ' (' . $erno . ')</div></div>');
		else
			$this->cmd('pass ' . $minelink['pass']);
	}
	
	private function cmd($cmd)
	{
		fwrite($this->socket, $cmd . "\n");
		$read = array($this->socket);
		$write = array();
		$except = array();
		while(stream_select($read, $write, $except, 0, 100000))
			$return .= fgets($read[0]);
		return $return;
	}

	public function playercount()
	{
		$data = self::cmd('playercount');
		$return = explode("\n", $data);
		return trim($return[0]);
	}

	public function maxplayers()
	{
		$data = self::cmd('maxplayers');
		$return = explode("\n", $data);
		return trim($return[0]);
	}

	public function players()
	{
		$data = self::cmd('getplayers');
		return trim($data);
	}

	private function __destruct()
	{
		socket_close($this->socket);
	}
}

?>