![](/logo.png?raw=true)

deus-stock is an application (being) written in php for a fictional company called Deus Investments. It is a stock market tool that manages users, gathers financial information from Yahoo, and displays a mobile-friendly web interface. A user can search up a stock, add it to his or her list, and monitor it on the real-time "Your Investments" panel.

By default the application uses a test user. One would have to create the database in order to set up a seperate account.

News
----
The news panel uses a yahoo api to moniter financial news concerning your stocks, and the stock market as a whole.

Security
--------
The queries are done using mysqli and escaping the string using `mysqli_real_escape_string()`, and all external data goes through filters before being injected into the web page, as to prevent XSS.
