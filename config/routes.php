<?php

declare(strict_types=1);

use Johncms\Guestbook\Controllers\GuestbookController;
use Johncms\Router\RouteCollection;
use Johncms\Users\Middlewares\AuthorizedUserMiddleware;
use Johncms\Users\Middlewares\HasPermissionMiddleware;

return function (RouteCollection $router) {
    $router->map(['GET', 'POST'], '/guestbook/', [GuestbookController::class, 'index'])->setName('guestbook.index');

    $router->group(
        '/guestbook',
        function (RouteCollection $router) {
            $router->get('/ga/', [GuestbookController::class, 'switchGuestbookType'])->setName('guestbook.switch_type');

            $router->post('/upload_file/', [GuestbookController::class, 'loadFile'])
                ->addMiddleware(AuthorizedUserMiddleware::class)
                ->setName('guestbook.uploadFile');

            $router->map(['GET', 'POST'], '/edit/{id:number}/', [GuestbookController::class, 'edit'])
                ->addMiddleware(new HasPermissionMiddleware('guestbook_delete_posts'))
                ->setName('guestbook.edit');

            $router->map(['GET', 'POST'], '/delpost/{id:number}/', [GuestbookController::class, 'delete'])
                ->addMiddleware(new HasPermissionMiddleware('guestbook_delete_posts'))
                ->setName('guestbook.delete');

            $router->map(['GET', 'POST'], '/reply/{id:number}/', [GuestbookController::class, 'reply'])
                ->addMiddleware(new HasPermissionMiddleware('guestbook_delete_posts'))
                ->setName('guestbook.reply');

            $router->map(['GET', 'POST'], '/clean/', [GuestbookController::class, 'clean'])
                ->addMiddleware(new HasPermissionMiddleware('guestbook_clear'))
                ->setName('guestbook.clean');
        }
    );
};
