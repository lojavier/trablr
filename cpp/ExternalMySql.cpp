#include "common.h"
using namespace std;

TrablrMySql::TrablrMySql(void) :
	DB_SERVER("tcp://127.0.0.1:3306"),
	DB_USERNAME("root"),
	DB_PASSWORD("spartan"),
	DB_SCHEMA("TRABLR_DB")
{ 
	printf("Creating Trablr Mysql\n");
	try {
		sql::Driver *driver;
		
		/* Create a connection */
		driver = get_driver_instance();
		con = driver->connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
	
		/* Connect to the MySQL test database */
		// con->setSchema(DB_SCHEMA);
		stmt = con->createStatement();
		stmt->execute("USE " + DB_SCHEMA);

	} catch (sql::SQLException &e) {
		cout << "# ERR: SQLException in " << __FILE__;
		cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << endl;
		cout << "# ERR: " << e.what();
		cout << " (MySQL error code: " << e.getErrorCode();
		cout << ", SQLState: " << e.getSQLState() << " )" << endl;
	}
}

TrablrMySql::~TrablrMySql(void) 
{ 
	printf("Destroying Trablr Mysql\n");
	delete con;
}

void TrablrMySql::updateFavoriteRouteUsage(struct mg_connection *nc, struct http_message *hm)
{
	string json_result = "{\"test\":0}";
	string statement = "";
	// char user_id[10], stop_id_start[10], stop_id_end[10];
	char favorites_id[11];
	// mg_get_http_var(&hm->body, "user_id", user_id, sizeof(user_id));
 //    mg_get_http_var(&hm->body, "stop_id_start", stop_id_start, sizeof(stop_id_start));
 //    mg_get_http_var(&hm->body, "stop_id_end", stop_id_end, sizeof(stop_id_end));
    mg_get_http_var(&hm->body, "favorites_id", favorites_id, sizeof(favorites_id));

	try {
		statement = "UPDATE USER_FAVORITES SET CLICK_COUNT=CLICK_COUNT+1 WHERE FAVORITES_ID=";
		statement.append(favorites_id);
        cout << statement << endl;
		stmt->execute(statement);
		delete stmt;

	} catch (sql::SQLException &e) {
		cout << "# ERR: SQLException in " << __FILE__;
		cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << endl;
		cout << "# ERR: " << e.what();
		cout << " (MySQL error code: " << e.getErrorCode();
		cout << ", SQLState: " << e.getSQLState() << " )" << endl;
	}

	cout << "Done." << endl;
    mg_printf(nc, "%s", "HTTP/1.1 200 OK\r\nTransfer-Encoding: chunked\r\n\r\n");
    mg_printf_http_chunk(nc, json_result.c_str());
    mg_send_http_chunk(nc, "", 0);
}

void TrablrMySql::insertFavoriteRoute(struct mg_connection *nc, struct http_message *hm)
{
	string json_result = "{\"test\":0}";
	string statement = "";
	char user_id[10], stop_id_start[10], stop_id_end[10];
	mg_get_http_var(&hm->body, "user_id", user_id, sizeof(user_id));
    mg_get_http_var(&hm->body, "stop_id_start", stop_id_start, sizeof(stop_id_start));
    mg_get_http_var(&hm->body, "stop_id_end", stop_id_end, sizeof(stop_id_end));

	try {
		// res = stmt->executeQuery("SELECT * FROM TRANSIT_INFO");
		// while (res->next()) {
		// 	cout << "TRANSIT_ID = " << res->getInt("TRANSIT_ID") << endl;
		// 	cout << "STOP_ID = " << res->getInt("STOP_ID") << endl;
		// 	cout << "LINE_ID = " << res->getInt("LINE_ID") << endl;
		// 	cout << "STOP_NAME = " << res->getString("STOP_NAME") << endl;
		// }
		// delete res;

		statement = "INSERT INTO USER_FAVORITES (USER_ID,STOP_ID_START,STOP_ID_END,PRIORITY) VALUES (";
		statement.append(user_id);
		statement += ",";
		statement.append(stop_id_start);
		statement += ",";
		statement.append(stop_id_end);
		statement += ",";
		statement.append("4");
		statement += ")";
        cout << statement << endl;
		stmt->execute(statement);

		delete stmt;

	} catch (sql::SQLException &e) {
		cout << "# ERR: SQLException in " << __FILE__;
		cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << endl;
		cout << "# ERR: " << e.what();
		cout << " (MySQL error code: " << e.getErrorCode();
		cout << ", SQLState: " << e.getSQLState() << " )" << endl;
	}

	cout << "Done." << endl;
    mg_printf(nc, "%s", "HTTP/1.1 200 OK\r\nTransfer-Encoding: chunked\r\n\r\n");
    mg_printf_http_chunk(nc, json_result.c_str());
    mg_send_http_chunk(nc, "", 0);
}
