<?php
use yswery\DNS\AbstractStorageProvider;

class LxdSocketResolver extends AbstractStorageProvider
{
	private static $TYPE_A = 1;
	private static $TYPE_AAAA = 28;

	public function get_answer($question)
	{
		$hostname = rtrim($question[0]['qname'], '.');
		$data = $this->loadContainerData($hostname);

		if ($data->type === 'error' || $data->metadata->status !== 'Running') {
			return [];
		}

		$addressFamily = '';
		switch ($question[0]['qtype']) {
			case self::$TYPE_A:
				$addressFamily = 'inet';
				break;
			case self::$TYPE_AAAA:
				$addressFamily = 'inet6';
				break;
		}

		$records = [];
		foreach ($data->metadata->network->eth0->addresses as $address) {
			if ($address->family === $addressFamily
				&& $address->scope === 'global'
			) {
				$records[] = [
					'name' => $question[0]['qname'],
					'class' => $question[0]['qclass'],
					'ttl' => 0,
					'data' => [
						'type' => $question[0]['qtype'],
						'value' => $address->address
					]
				];
			}
		}

		return $records;
	}

	private function loadContainerData($hostname)
	{
		$url = "/1.0/containers/$hostname/state";

		$fp = fsockopen("unix:///var/lib/lxd/unix.socket");
		if (!$fp) {
			echo 'error!';
		} else {
			$out = "GET $url HTTP/1.1\r\n";
			$out .= "Host: localhost\r\n";
			$out .= "Connection: Close\r\n\r\n";
			fwrite($fp, $out);
			$responseJson = '';
			while (!feof($fp)) {
				$rawResponse = fgets($fp, 20000);
				if (substr($rawResponse, 0, 1) === '{') {
					$responseJson = $rawResponse;
					break;
				}
			}
			fclose($fp);

			$response = json_decode($responseJson);
			return $response;
		}
	}
}