#include <iostream>
using namespace std;

// Part 1: Design a simple class hierarchy. Start with a base class "Animal", 
// and create derived classes "Dog" and "Cat". Each derived class should have its 
// unique behavior. Demonstrate method overriding.

// Base class Animal
class Animal {
public:
    // Method for polymorphism demonstration
    virtual void speak() {
        cout << "Animal makes a sound!" << endl;  // Base method for Animal
    }
};

// Derived class Dog
class Dog : public Animal {
public:
    // Overriding the speak method for Dog
    void speak() override {
        cout << "Dog barks: Woof Woof!" << endl;
    }
};

// Derived class Cat
class Cat : public Animal {
public:
    // Overriding the speak method for Cat
    void speak() override {
        cout << "Cat meows: Meow Meow!" << endl;
    }
};

// Part 2: What relationship (Abstraction, Encapsulation, Inheritance, Polymorphism) 
// would you say is established in question number 1?

// This code demonstrates the following OOP principles:
// 1. **Inheritance**: The Dog and Cat classes inherit from the Animal class.
//    This allows Dog and Cat to reuse and extend the behavior defined in Animal.
// 2. **Polymorphism**: The speak() method is overridden in both Dog and Cat classes.
//    Through the use of polymorphism, the makeSound() function can call the correct
//    speak() method depending on whether it's a Dog or a Cat.
// 3. **Abstraction**: The Animal class provides an abstract representation of what an
//    animal's behavior could be (speak), while leaving the details of how they speak
//    to the derived classes (Dog and Cat).
// 4. **Encapsulation**: The speak() method in each class (Animal, Dog, and Cat)
//    is encapsulated within each class. Each class has its own version of this method, 
//    and the details are hidden from other classes.

// Part 3: Use the function makeSound() to demonstrate polymorphism using your 
// answer to question number 1.

// Function to demonstrate polymorphism
void makeSound(Animal* animal) {
    animal->speak();  // Calls the correct speak() method based on the actual object type
}

int main() {
    // Creating objects of each class
    Animal* animal = new Animal();  // Instance of Animal
    Animal* dog = new Dog();        // Instance of Dog
    Animal* cat = new Cat();        // Instance of Cat

    // Demonstrating method overriding (Part 1)
    animal->speak();  // Outputs: Animal makes a sound!
    dog->speak();     // Outputs: Dog barks: Woof Woof!
    cat->speak();     // Outputs: Cat meows: Meow Meow!

    // Demonstrating polymorphism using makeSound (Part 3)
    makeSound(dog);  // Outputs: Dog barks: Woof Woof! (Polymorphism)
    makeSound(cat);  // Outputs: Cat meows: Meow Meow! (Polymorphism)

    // Cleaning up
    delete animal;
    delete dog;
    delete cat;

    return 0;
}
