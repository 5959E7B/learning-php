<?php 
	class Accessor {
		private $valid_tokens = [];

		public function __construct() {
			# init or smth
		}

		public function login($username, $password) {
			if ($username == "John" and $password == "password") {
				return $this->generate_token();
			} else {
				throw new Exception("Invalid credentials");
			}
		}

		private function generate_token() {
			do {
				$token = random_int(0, 2000000000);

			# i need an "invalid" token, e.g. one not in the valid_tokens already
			} while ($this->is_valid_token($token));

			array_push($this->valid_tokens, $token);
			return $token;
		}

		public function is_valid_token($token) {
			/* $valid = False;
			foreach ($this->valid_tokens as $token) {
				if ($token_to_check == $token) {
					$valid = True;
					break;
				}
			}
			return $valid; */

			return in_array($token, $this->valid_tokens);
		}

		public function access($path, $token) {
			if ($this->is_valid_token($token)) {
				return "Content of the page " . $path . " or something\n";
			} else {
				throw new Exception("Invalid token");
			}
		}
	}

	$ac = new Accessor();

	$tkn = $ac->login("John", "password");

	var_dump($tkn);

	try {
		echo $ac->access("/home/john", $tkn);
	} catch (Exception $e) {
		echo "Invalid token: " . $tkn;
	}

	try {
		echo $ac->access("/home/john", -1);
	} catch (Exception $e) {
		echo "Invalid token: " . -1;
	}


 ?>