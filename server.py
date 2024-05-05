from flask import Flask, render_template, redirect, url_for, flash
from flask_sqlalchemy import SQLAlchemy
from flask_wtf import FlaskForm
from wtforms import StringField, PasswordField, SubmitField, TextAreaField, FloatField, DateField, TimeField, \
    SelectField, BooleanField
from wtforms.validators import DataRequired, Email, EqualTo, ValidationError, Email, Length
from flask_bcrypt import Bcrypt
from datetime import datetime, date
from enum import Enum

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://root@localhost/taskmaster'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.secret_key = 'your_secret_key'
db = SQLAlchemy(app)
bcrypt = Bcrypt(app)


class PriorityEnum(Enum):
    Low = 'Low'
    Medium = 'Medium'
    High = 'High'


class Task(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    category = db.Column(db.String(255), nullable=False)
    priority = db.Column(db.Enum(PriorityEnum), nullable=False)
    task_name = db.Column(db.String(255), nullable=False)
    description = db.Column(db.Text, nullable=True)
    due_date = db.Column(db.Date, nullable=True)
    status = db.Column(db.String(255), nullable=True)
    assigned_user = db.Column(db.String(255), nullable=True)
    estimated_time = db.Column(db.String(50), nullable=True)


def get_due_tasks():
    today = date.today()
    return Task.query.filter(Task.due_date == today).all()


@app.route('/')
def home():
    return render_template('index.html')


@app.route('/layout')
def layout():
    return render_template('layout.html')


@app.route('/create_task')
def create_task():
    return render_template('create.html')


@app.route('/bell')
def bell():
    return render_template('notification.html')


@app.route('/notifications')
def notifications():
    # Logic to check due dates of tasks
    # For demonstration purposes, let's assume a task is due today
    due_tasks = get_due_tasks()

    if due_tasks:
        for task in due_tasks:
            flash(f'Task "{task.task_name}" is due today!', 'info')
    else:
        flash('No tasks due today', 'info')

    return redirect(url_for('home'))


if __name__ == '__main__':
    with app.app_context():
        db.create_all()
    app.run(debug=True)
