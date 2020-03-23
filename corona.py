from urllib.request import urlopen as uReq
from bs4 import BeautifulSoup as soup
import json
import time

def JSONKeyFormatter(argument): 
    Formatted = { 
        "s. no." : "num", 
        "name of state / ut": "name", 
        "total confirmed cases (indian national)": "indian_cases", 
        "total confirmed cases ( foreign national )": "foreign_cases", 
        "cured/discharged/migrated":"cured",
        "death": "deaths", 
    } 
  
    # get() method of dictionary data type returns  
    # value of passed argument if it is present  
    # in dictionary otherwise second argument will 
    # be assigned as default value of passed argument 
    return Formatted.get(argument, "error")

def getData(indent=None):
    try:
        dataSource = "https://www.mohfw.gov.in/"
        uClient2 = uReq(dataSource)
        page_html = uClient2.read()
        uClient2.close()

        page_soup = soup(page_html, "html.parser")

        dataSet = page_soup.findAll("div", {"class": "content newtab"})

        # validity = dataSet[0].findAll("p")
        # with open('lastUpdated.txt', 'w') as f:
        #     f.write(validity[0].text[37:-1])

        body = dataSet[0].findAll("tbody")

        rows = []
        rows.extend(body[0].findAll("tr"))

        headers = {}
        thead = dataSet[0].find("thead")

        if thead:
            thead = thead.find_all("th")
            for i in range(len(thead)):
                headers[i] = JSONKeyFormatter(thead[i].text.strip().lower())
                # if(headers[i])

        data = []
        for row in rows:
            cells = row.find_all("td")
            if thead:
                items = {}
                for index in headers:
                    items[headers[index]] = cells[index].text
            # else:
                # items = []
                # for index in cells:
                #     items.append(index.text.strip())
            
            data.append(items)
            with open('data.json', 'w') as f:
                f.write(json.dumps(data))
            with open('lastUpdated.txt', 'w') as f:
                f.write(time.ctime())
        return 'OK'
    except:
        return 'Last Updated'

while True:
    print(getData() + " " + time.ctime())
    time.sleep(300)

