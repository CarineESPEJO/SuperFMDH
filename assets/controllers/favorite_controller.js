// assets/controllers/favorite_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = { url: String };

    connect() {
        this.element.addEventListener('click', this.toggleFavorite.bind(this));
    }

    async toggleFavorite(event) {
        event.preventDefault();
        try {
            const response = await fetch(this.urlValue, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();

            if (data.status === 'added') {
                this.element.classList.add('favorited');
            } else if (data.status === 'removed') {
                this.element.classList.remove('favorited');
            }
        } catch (error) {
            console.error('Favorite toggle failed', error);
        }
    }
}
