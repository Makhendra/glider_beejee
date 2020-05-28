<?php

namespace App\Admin\Controllers;

use App\Models\GroupTask;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GroupsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title;

    public function __construct()
    {
        $this->title = __('messages.groups');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GroupTask());
        $grid->column('name', __('messages.name'));
        $grid->column('active', __('messages.active'))->switch();
        $grid->column('sort', __('messages.sort'))->editable();
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
        $show = new Show(GroupTask::findOrFail($id));

        $show->field('id', __('messages.id'));
        $show->field('name', __('messages.name'));
        $show->field('active', __('messages.active'));
        $show->field('sort', __('messages.sort'));
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
        $form = new Form(new GroupTask());
        $form->tab(
            __('messages.group'),
            function ($form) {
                $form->text('name', __('messages.name'));
                $form->text('sort', __('messages.sort'));
                $form->switch('active', __('messages.active'))->default(1);
            }
        );
        $form->tab(
            __('messages.tasks'),
            function ($form) {
                $form->hasMany(
                    'tasks',
                    function (Form\NestedForm $form) {
                        $form->text('title', __('messages.task_title'));
                        $form->number('type', __('messages.type'))->default(1)->rules(function ($form) {
                            if (!$id = $form->model()->id) {
                                return 'unique:tasks,type';
                            }
                        });
                        $form->ckeditor('task_text', __('messages.task_text'));
                        $form->ckeditor('decision', __('messages.how_decision'));
                        $form->ckeditor('answer', __('messages.format_answer'));
                        $form->switch('active', __('messages.active'));
                    }
                );
            }
        );
        $form->tab(
            __('messages.seo'),
            function ($form) {
                $form->text('seo.meta_title', __('messages.meta_title'));
                $form->textarea('seo.meta_description', __('messages.meta_description'));
                $form->tags('seo.meta_keywords', __('messages.meta_keywords'));
                $form->saving(function (Form $form) {
                    if (empty($form->{'seo.meta_title'})) {
                        $form->ignore('seo.meta_title');
                    }
                    if (empty($form->{'seo.meta_description'})) {
                        $form->ignore('seo.meta_description');
                    }
                    if (empty($form->{'seo.meta_keywords'})) {
                        $form->ignore('seo.meta_keywords');
                    }
                });
            }
        );

        return $form;
    }
}
