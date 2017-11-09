<?php

class AttachmentController extends Controller
{
	public function action_form()
	{
		$this->render('_form');
	}

	public function action_search()
	{
		$this->render('_search');
	}

	public function actionCreate()
	{
		$this->render('create');
	}

	public function actionIndex()
	{
		$this->render('index');
	}

}