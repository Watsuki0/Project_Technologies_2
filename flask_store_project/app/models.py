from . import db


class Game(db.Model):
    __tablename__ = 'games'

    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String, nullable=False)
    description = db.Column(db.Text, nullable=True)
    price = db.Column(db.Numeric, nullable=False)
    image = db.Column(db.String, nullable=True)
def get_games_sorted():
        return Game.query.order_by(Game.id.asc()).all()
