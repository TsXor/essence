<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use Carbon\Carbon;
use Flarum\Api\Controller\ListDiscussionsController;
use Flarum\Api\Serializer\DiscussionSerializer;
use Flarum\Discussion\Discussion;
use Flarum\Discussion\Event\Saving;
use Flarum\Discussion\Filter\DiscussionFilterer;
use Flarum\Discussion\Search\DiscussionSearcher;
use Flarum\Extend;
use TsXor\Essence\Event\DiscussionWasSetEssential;
use TsXor\Essence\Event\DiscussionWasUnsetEssential;
use TsXor\Essence\Listener;
use TsXor\Essence\Listener\SaveEssentialStateToDatabase;
//use TsXor\Essence\PinEssenceDiscussionsToTop;
use TsXor\Essence\Post\DiscussionSetEssentialPost;
use TsXor\Essence\Query\EssentialFilterGambit;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Model(Discussion::class))
        ->cast('last_set_essential_at', 'datetime'),

    (new Extend\Post())
        ->type(DiscussionSetEssentialPost::class),

    (new Extend\ApiSerializer(DiscussionSerializer::class))
        ->attribute('isEssential', function (DiscussionSerializer $serializer, $discussion) {
            return ($discussion->last_set_essential_at !== null);
        })
        ->attribute('lastSetEssentialAt', function (DiscussionSerializer $serializer, $discussion) {
            // ensure non-null return value
            return ($discussion->last_set_essential_at !== null)
                ? $discussion->last_set_essential_at
                : Carbon::now();
        })
        ->attribute('canSetEssential', function (DiscussionSerializer $serializer, $discussion) {
            return (bool) $serializer->getActor()->can('setEssential', $discussion);
        }),

    (new Extend\ApiController(ListDiscussionsController::class))
        ->addInclude('firstPost'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Event())
        ->listen(Saving::class, SaveEssentialStateToDatabase::class)
        ->listen(DiscussionWasSetEssential::class, [Listener\CreatePostWhenDiscussionIsSetEssential::class, 'whenDiscussionWasSetEssential'])
        ->listen(DiscussionWasUnsetEssential::class, [Listener\CreatePostWhenDiscussionIsSetEssential::class, 'whenDiscussionWasUnsetEssential']),

    (new Extend\Filter(DiscussionFilterer::class))
        ->addFilter(EssentialFilterGambit::class),
        // "essence" discussions does not needed to be pinned to top
        //->addFilterMutator(PinEssentialDiscussionsToTop::class),

    (new Extend\SimpleFlarumSearch(DiscussionSearcher::class))
        ->addGambit(EssentialFilterGambit::class),
];
