import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import humanTime from 'flarum/common/helpers/humanTime';
import DiscussionHero from 'flarum/forum/components/DiscussionHero';

export default function addEssentialDate() {
  // put date after title
  extend(DiscussionHero.prototype, 'items', function (items) {
    if (!this.attrs.discussion.isEssential()) return;
    const essential_date = this.attrs.discussion.lastSetEssentialAt();
    items.add(
      'essential-date',
      <span className="DiscussionHero-essential-date">
        {app.translator.trans('flarum-essence.forum.discussion_hero.essential_date', {
          time: humanTime(essential_date)
        })}
      </span>,
      -1
    );
  });
}
