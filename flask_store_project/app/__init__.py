from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from .config import Config

db = SQLAlchemy()


def create_app():
    app = Flask(__name__)

    # Charger la configuration
    app.config.from_object(Config)

    # Initialiser l'extension SQLAlchemy avec l'application Flask
    db.init_app(app)

    # Enregistrer les Blueprints
    from .main import main_bp
    app.register_blueprint(main_bp)

    return app
