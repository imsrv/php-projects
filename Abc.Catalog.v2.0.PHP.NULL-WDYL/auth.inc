<?php

//------------------------------------------------------------------------
// This script is a part of Zakkis ABC Catalog.
//
// Version: 2.0
// Homepage: www.zakkis.ca
// Copyright (c) 2002-2003 Zakkis Technology, Inc.
// All rights reserved.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
// "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
// LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
// FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
// REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
// INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
// (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
// SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
// HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
// STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
// OF THE POSSIBILITY OF SUCH DAMAGE.
//
//------------------------------------------------------------------------

include_once ('util.php');

function CheckUserAuth()
{
	if( IsPost() )
	{
		$login = ExtractParam('login');
		$password = ExtractParam('password');
	
		if( $login != '' && $password != '' )
		{
			include_once ('secure.inc');
			if( $login == $LOGIN && $password == $PASSWORD && !file_exists('admin.deny') )
			{
				session_start();
				session_unset();
				session_register('auth');
				session_register('guest');
				$_SESSION[auth] = true;
				$_SESSION[guest] = 0;
				return 'ok';
			}
			elseif( $login == 'demo' && $password == 'demo' && file_exists('demo.allow') )
			{
				session_start();
				session_unset();
				session_register('auth');
				session_register('guest');
				$_SESSION[auth] = true;
				$_SESSION[guest] = 1;
				return 'ok';
			}

			return 'Invalid username/password';
		}

		return 'Username/password required';	
	}

	return 'Please, login.';
}

?>