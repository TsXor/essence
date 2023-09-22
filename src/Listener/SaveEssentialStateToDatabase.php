<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace TsXor\Essence\Listener;

use Carbon\Carbon;
use Flarum\Discussion\Event\Saving;
use TsXor\Essence\Event\DiscussionWasSetEssential;
use TsXor\Essence\Event\DiscussionWasUnsetEssential;

class SaveEssentialStateToDatabase
{
    /**
     * @param Saving $event
     */
    public function handle(Saving $event)
    {
        if (isset($event->data['attributes']['isEssential'])) {
            $isEssential = (bool) $event->data['attributes']['isEssential'];
            $discussion = $event->discussion;
            $actor = $event->actor;

            $actor->assertCan('setEssential', $discussion);

            if (($discussion->last_set_essential_at !== null) === $isEssential) {
                return;
            }

            $discussion->last_set_essential_at = $isEssential ? Carbon::now() : null;

            $discussion->raise(
                $isEssential
                    ? new DiscussionWasSetEssential($discussion, $actor)
                    : new DiscussionWasUnsetEssential($discussion, $actor)
            );
        }
    }
}
