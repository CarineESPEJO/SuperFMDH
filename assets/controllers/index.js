import { Application } from '@hotwired/stimulus';
import FavoriteController from './favorite_controller';

const application = Application.start();
application.register('favorite', FavoriteController);
