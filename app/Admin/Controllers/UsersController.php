<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title;

    public function __construct()
    {
        $this->title = __('messages.users');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('messages.id'));
        $grid->column('name', __('messages.name'));
        $grid->column('email', __('messages.email'));
        $grid->column('active', __('messages.active'))->switch();
        $grid->column('created_at', __('messages.created_at'))->date('d.m.Y H:i');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('messages.id'));
        $show->field('name', __('messages.name'));
        $show->field('email', __('messages.email'));
        $show->field('email_verified_at', __('messages.email verified_at'));
        $show->field('password', __('messages.password'));
        $show->field('remember_token', __('messages.remember token'));
        $show->field('created_at', __('messages.created_at'));
        $show->field('updated_at', __('messages.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('messages.name'));
        $form->email('email', __('messages.email'));
        $form->switch('active',  __('messages.active'));
        $form->ignore(['password_confirmation']);
        $form->password('password', __('messages.new_password'))->rules('confirmed');
        $form->password('password_confirmation',  __('messages.confirm_password'));
        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            }
        });

        return $form;
    }
}
