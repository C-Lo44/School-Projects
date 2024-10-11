import paho.mqtt.client as mqtt
import csv
import time
import heapq

def on_connect(client, userdata, flags, rc):
    print(f"Connected with result code {rc}")

client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION1)
client.on_connect = on_connect

# If you forget the following line (or the user/pass is wrong) then you might get
# "Connected with result code 5" which means authentication failure
client.username_pw_set("mszpotek27", "test123")

client.connect("34.172.236.4", 1883, 60)

# Read data from CSV file and extract scores
scores = []
with open('Score_Data.csv', 'r') as file:
    csv_reader = csv.reader(file)
    for row in csv_reader:
        score = float(row[0])  # Assuming scores are numeric
        scores.append(score)

# Get top 10 scores
top_10_scores = heapq.nlargest(10, scores)

# Publish top 10 scores to MQTT broker
for score in top_10_scores:
    # Publish data to MQTT broker
    client.publish('Score_Data', payload=str(score), qos=0, retain=False)
    print(f"publishing '{score}' to 'Score_Data'")
    time.sleep(1)

client.loop_forever()

