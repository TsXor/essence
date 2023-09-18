import Extend from 'flarum/common/extenders';
import Discussion from 'flarum/common/models/Discussion';
import DiscussionSetEssentialPost from './components/DiscussionSetEssentialPost';

export default [
  new Extend.PostTypes() //
    .add('discussionSetEssential', DiscussionSetEssentialPost),

  new Extend.Model(Discussion) //
    .attribute<boolean>('isEssential')
    .attribute<boolean>('canSetEssential'),
];
