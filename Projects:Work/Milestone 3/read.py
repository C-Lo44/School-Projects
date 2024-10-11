 import csv
from flask import Flask, render_template

app = Flask(__name__, template_folder='templates')

@app.route('/')
def index():
    scores = []

    # Read scores from CSV file
    with open('/Score_Data.csv', 'r') as file:
        csv_reader = csv.reader(file)
        for row in csv_reader:
            scores.append(int(row[0]))  # Assuming scores are in the first column of the CSV file

    sorted_scores = sorted(scores, reverse=True)  # Sort scores in descending order
        
    print("Scores:", sorted_scores)    
        
    return render_template('scores.html', scores=sorted_scores)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=8080)
