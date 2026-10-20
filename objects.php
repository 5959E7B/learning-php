<?php 
	class Accessor {
		private array $valid_tokens = [];
		private array $login_data = [];

		public function __construct() {
			# init or smth
		}

		public function login(string $username, string $password): int {
			if (array_key_exists($username, $this->login_data)) {
				if ($this->login_data[$username] == $password) {
					return $this->generate_token();
				} else {
					throw new Exception("Incorrect password");
				}
			} else {
				throw new Exception("Incorrect username");
			}
		}

		public function register(string $username, string $password): void {
			if (!array_key_exists($username, $this->login_data)) {
				$this->login_data[$username] = $password;
			} else {
				throw new Exception("User already exists");
			}
		}

		private function generate_token(): int {
			do {
				$token = random_int(0, 2000000000);
			# i need an "invalid" token, e.g. one not in the valid_tokens already
			} while ($this->is_valid_token($token));

			array_push($this->valid_tokens, $token);
			return $token;
		}

		public function is_valid_token(int $token): bool {
			return in_array($token, $this->valid_tokens);
		}

		public function access(string $path, int $token): string {
			if ($this->is_valid_token($token)) {
				return "Content of the page " . $path;
			} else {
				throw new Exception("Invalid token");
			}
		}

		public function list_users(string $tkn): void {
			if ($tkn == "very_secure_password") {
				print("USER\tPASSWORD\n");
				foreach ($this->login_data as $username => $password) {
					print($username . "\t" . $password . "\n");
				}
			} else {
				throw new Exception("Unauthorized");
			}
		}
	}

	$ac = new Accessor();

	$ac->register("John", "password");

	$tkn = $ac->login("John", "password");

	var_dump($tkn);

	try {
		echo $ac->access("/home/john", $tkn) . "\n";
	} catch (Exception $e) {
		echo "Invalid token: " . $tkn . "\n";
	}

	try {
		echo $ac->access("/home/john", -1 ) . "\n";
	} catch (Exception $e) {
		echo "Invalid token: " . -1 . "\n";
	}

	$ac->list_users("very_secure_password");

 ?>