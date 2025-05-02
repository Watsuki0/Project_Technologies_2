from datetime import datetime

from flask import Blueprint, render_template, abort
from .models import Game, get_games_sorted

main_bp = Blueprint('main', __name__)


@main_bp.route('/')
def index():
    games = Game.query.all()
    games = get_games_sorted()
    return render_template("index.html", games=games, year=datetime.now().year, show_back_button=False)

@main_bp.route('/product/<int:game_id>')
def product_detail(game_id):
    game = Game.query.get(game_id)
    if not game:
        abort(404)
    return render_template("product_detail.html", game=game, year=datetime.now().year, show_back_button=True)
