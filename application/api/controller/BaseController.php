<?php
namespace app\api\controller;

use app\api\service\Token;
use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
	protected function checkPrimaryScope()
	{
		TokenService::needPrimaryScope();
	}

	protected function checkExclusiveScope()
	{
		TokenService::needExclusiveScope();
	}

    protected function checkSuperScope()
    {
        Token::needSuperScope();
    }
}