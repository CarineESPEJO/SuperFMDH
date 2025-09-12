import { startStimulusApp } from '@symfony/stimulus-bridge';
import '@fortawesome/fontawesome-free/css/all.min.css';
import '@fortawesome/fontawesome-free/js/all.min.js';

// Start Stimulus
const app = startStimulusApp();

// Register controllers
import FavoriteController from './controllers/favorite_controller.js';
app.register('favorite', FavoriteController);
