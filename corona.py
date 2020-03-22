from urllib.request import urlopen as uReq
from bs4 import BeautifulSoup as soup
import json
import time

def getData():
    try:
        dataSource = "https://www.mohfw.gov.in/"
        uClient2 = uReq(dataSource)
        page_html = uClient2.read()
        uClient2.close()

        page_soup = soup(page_html, "html.parser")

        dataSet = page_soup.findAll("div", {"class": "content newtab"})
        validity = dataSet[0].findAll("p")
        with open('lastUpdated.txt', 'w') as f:
            f.write(validity[0].text[37:-1])
        x = dataSet[0].findAll("tbody")
        trs = []
        trs.extend(x[0].findAll("tr"))
        data = []
        for row in trs:
            cells = row.find_all("td")
            items = []
            for index in cells:
                items.append(index.text.strip())
            data.append(items)
        with open('data.json', 'w') as f:
            f.write(json.dumps(data))
        return 'Latest'
    except:
        return 'Last Updated'

while True:
    print(getData() + " " + time.ctime())
    time.sleep(300)

