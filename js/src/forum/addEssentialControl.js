import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import DiscussionControls from 'flarum/forum/utils/DiscussionControls';
import DiscussionPage from 'flarum/forum/components/DiscussionPage';
import Button from 'flarum/common/components/Button';

export default function addEssentialStateControl() {
  extend(DiscussionControls, 'moderationControls', function (items, discussion) {
    if (discussion.canSetEssential()) {
      var action = discussion.isEssential() ? 'unset' : 'set';
      items.add(
        'essence',
        <Button icon="fas fa-star" onclick={this.filpEssentialStatusAction.bind(discussion)}>
          {app.translator.trans(
            `flarum-essence.forum.discussion_controls.${action}_essential_button`
          )}
        </Button>
      );
    }
  });

  DiscussionControls.filpEssentialStatusAction = function () {
    this.save({ isEssential: !this.isEssential() }).then(() => {
      if (app.current.matches(DiscussionPage)) {
        app.current.get('stream').update();
      }

      m.redraw();
    });
  };
}
