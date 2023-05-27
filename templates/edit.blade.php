@extends('system::layout/default')
@section('content')
    <h4><?= __('Edit message') ?></h4>
    @if (! empty($errors['csrf_token']))
        <div class="alert alert-danger"><?= implode(', ', $errors['csrf_token']) ?></div>
    @endif
    <form action="<?= $actionUrl ?>" method="post">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>"/>
        <p>
            <b><?= __('Author') ?>:</b> {{$message->name}}
        <p>
        @include('johncms/guestbook::ckeditor',  [
            'label'     => __('Message'),
            'errors'    => implode(', ', $errors['message'] ?? []),
            'value'     => $text,
            'uploadUrl' => $uploadUrl,
        ])
        <div class="mt-2">
            <button type="submit" name="submit" value="submit" class="btn btn-primary me-2"><?= __('Save') ?></button>
            <a href="<?= $backUrl ?>" class="btn btn-outline-primary"><?= __('Back') ?></a>
        </div>
    </form>
@endsection
