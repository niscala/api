<?php

class Users_test extends TestCase
{
	var $xml_user1 = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<xml><id>1</id><first_name>John</first_name><last_name>John</last_name><email>john@example.com</email><password>Loves coding</password></xml>\n";

	public function test_take_user_get()
	{
		$output = $this->request('GET', 'users/take_user');
		$expected = '[{"id":1,"first_name":"John","last_name":"John", "email":"john@example.com","password":"John"},{"id":2,"first_name":"Jim", "last_name":"Jim", "email":"jim@example.com","password":"CodeIgniter"},{"id":3,"first_name":"Jane", "last_name":"Jane", "email":"jane@example.com","password":"jane123"}]';
		$this->assertEquals($expected, $output);
		$this->assertResponseCode(200);
	}

	public function test_take_user_get_id()
	{
		$output = $this->request('GET', 'users/take_user/id/1');
		$expected = '{"id":1,"first_name":"John","last_name":"John", "email":"john@example.com","password":"John"}';
		$this->assertEquals($expected, $output);
		$this->assertResponseCode(200);
	}
}
	