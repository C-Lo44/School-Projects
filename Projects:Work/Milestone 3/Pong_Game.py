# Import the necessary modules: SenseHat for interacting with the Sense HAT hardware,
# and sleep from time for controlling the game's update rate.
# Import CSV to write data to
from sense_hat import SenseHat
from time import sleep
import csv

# Initialize the SenseHat object.
sense = SenseHat()

# Define the color white as an RGB tuple.
white = (255, 255, 255)

# Initialize the bat's vertical position in the middle of the LED matrix.
bat_y = 4

# Initialize the ball's position and velocity. The ball starts in the middle of the matrix, moving diagonally.
ball_position = [3, 3]
ball_velocity = [1, 1]

score = 0
# Define the main game function.
def start_game():
    # Ask the player to select the game difficulty level, which determines the game's speed.
    level_time = ask_level()
    while True:
        # Clear the LED matrix display at the start of each loop iteration.
        sense.clear(0, 0, 0)
        # Draw the ball and the bat on the LED matrix.
        draw_ball()
        draw_bat()
        # Pause the game loop to control the speed of the game, based on the selected difficulty level.
        sleep(level_time)

# Define a function to ask the player for the game difficulty level.
def ask_level():
    # Display a welcome message and the difficulty level choices.
    print("Welcome to Pong 9.0\nPress 1 for Easy\nPress 2 for Medium\nPress 3 for Hard\nPress 4 for quit")
    level = int(input('enter the level of difficulty:'))
    # Return a time delay corresponding to the chosen difficulty level. Smaller values increase the game's difficulty.
    if level == 1:
        return 0.5
    elif level == 2:
        return 0.25
    elif level == 3:
        return 0.20
    elif level == 4:
        quit()
    else:
        # If the player enters an invalid choice, display an error message and restart the game.
        print("Invalid Input")
        start_game()

# Define a function to draw the bat on the LED matrix.
def draw_bat():
    # The bat consists of three vertically aligned pixels. It moves up and down at the left edge of the matrix.
    sense.set_pixel(0, bat_y, white)
    sense.set_pixel(0, bat_y + 1, white)
    sense.set_pixel(0, bat_y - 1, white)

# Define a function to update and draw the ball's position.
def draw_ball():
    # Set the ball's color to magenta and update its position based on its velocity.
    sense.set_pixel(ball_position[0], ball_position[1], 255, 0, 255)
    ball_position[0] += ball_velocity[0]
    ball_position[1] += ball_velocity[1]
    # Reverse the ball's horizontal velocity when it hits the right edge of the matrix.
    if ball_position[0] == 7:
        ball_velocity[0] = -ball_velocity[0]
    # Reverse the ball's vertical velocity when it hits the top or bottom edge of the matrix.
    if ball_position[1] == 0 or ball_position[1] == 7:
        ball_velocity[1] = -ball_velocity[1]
   
    if ball_position[0] == 1 and bat_y - 1 <= ball_position[1] <= bat_y + 1:
        ball_velocity[0] = -ball_velocity[0]
        global score
        score += 1
   # If the ball reaches the left edge, display a "You Lose" message, reset the ball, and restart the game.
    if ball_position[0] == 0:
        sense.show_message("Score: " + str(score))
        
        with open('Score_Data.csv', 'a') as f:
            csvwriter = csv.writer(f)
            csvwriter.writerow([score])
        f.close()        
        ball_position[0] = 3
        ball_position[1] = 3
        ball_velocity[1] = 1
        ball_velocity[0] = 1
        score = 0
        start_game()

# Define functions to move the bat up or down when the corresponding direction on the joystick is pressed.
def move_up(event):
    global bat_y
    if event.action == 'pressed' and bat_y > 1:
        bat_y -= 1

def move_down(event):
    global bat_y
    if event.action == 'pressed' and bat_y < 6:
        bat_y += 1

# Assign the joystick's up and down movements to the respective bat movement functions.
sense.stick.direction_up = move_up
sense.stick.direction_down = move_down

# Start the game.
start_game()
