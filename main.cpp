#include <iostream>
#include <fstream>
#include <string>

int main() {
    std::ofstream outfile("user_details.txt", std::ios::app);

    std::cout << "Content-type: text/html\n\n";
    std::cout << R"(
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Details Form</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                }

                .container {
                    max-width: 400px;
                    margin: 50px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                form {
                    display: grid;
                    gap: 10px;
                }

                label {
                    font-weight: bold;
                }

                input {
                    width: 100%;
                    padding: 8px;
                    box-sizing: border-box;
                }

                button {
                    background-color: #4caf50;
                    color: #fff;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <form action="#" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>

                    <label for="middle_name">Middle Name:</label>
                    <input type="text" id="middle_name" name="middle_name">

                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="mobile_number">Mobile Number:</label>
                    <input type="tel" id="mobile_number" name="mobile_number" required>

                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required>

                    <label for="last_login">Last Login:</label>
                    <input type="datetime-local" id="last_login" name="last_login">

                    <button type="submit">Submit</button>
                </form>
            </div>
        </body>
        </html>
    )";

    std::string username, password, first_name, middle_name, last_name, email, mobile_number, date_of_birth, last_login;

    std::cin >> username >> password >> first_name >> middle_name >> last_name >> email >> mobile_number >> date_of_birth >> last_login;

    outfile << username << " " << password << " " << first_name << " " << middle_name << " " << last_name << " "
            << email << " " << mobile_number << " " << date_of_birth << " " << last_login << "\n";

    std::cout << "Content-type: text/html\n\n";
    std::cout << "<h1>Form submitted successfully.</h1>";

    outfile.close();
    return 0;
}
