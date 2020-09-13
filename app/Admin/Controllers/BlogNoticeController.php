<?php

namespace App\Admin\Controllers;

use App\Models\BlogNotice;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BlogNoticeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\BlogNotice';

    public function index(Content $content)
    {
        return $content->header('公告管理')->description('公告列表')->body($this->grid()); // TODO: Change the autogenerated stub
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BlogNotice);
        $grid->model()->orderBy('notice_show', 'desc')->orderBy('id', 'desc');
        $grid->column('id', __('ID'));
        $grid->column('notice_title', __('公告标题'))->editable();
        $grid->column('notice_sort', __('公告排序'));
        $grid->column('notice_show', __('是否显示'))->using([1 => '显示', 2 => '隐藏']);
        $grid->column('created_at', __('添加时间'));

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
        $show = new Show(BlogNotice::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new BlogNotice);

        $form->text('notice_title', '公告标题')->attribute('autocomplete', 'off')->required()->rules('required|max:40');
        $form->simditor('notice_content', '公告内容')->rules('required');
        $form->number('notice_sort', '公告排序')->default(100)->rules('integer|between:0,999999');
        $states = [
            'on'  => ['value' => 1, 'text' => '显示', 'color' => 'info'],
            'off' => ['value' => 2, 'text' => '隐藏', 'color' => 'danger'],
        ];
        $form->switch('notice_show', '是否显示')->states($states)->default(1);

        return $form;
    }
}