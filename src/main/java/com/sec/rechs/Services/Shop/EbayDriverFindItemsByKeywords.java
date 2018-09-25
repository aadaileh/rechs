package com.sec.rechs.Services.Shop;

import com.sec.rechs.DTOs.EbaySearchResult;
import io.swagger.annotations.ApiOperation;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import org.w3c.dom.Document;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.xpath.XPath;
import javax.xml.xpath.XPathConstants;
import javax.xml.xpath.XPathExpression;
import javax.xml.xpath.XPathFactory;
import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.util.ArrayList;

@RestController
@RequestMapping("/api/shop/")
public class EbayDriverFindItemsByKeywords {

    public final static String EBAY_APP_ID = "AhmedAlA-RECHSMSC-PRD-68bbc5abd-b7b36a04";
    public final static String EBAY_FINDING_SERVICE_URI = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME="
            + "{operation}&SERVICE-VERSION={version}&SECURITY-APPNAME="
            + "{applicationId}&GLOBAL-ID={globalId}&keywords={keywords}"
            + "&paginationInput.entriesPerPage={maxresults}";
    public static final String SERVICE_VERSION = "1.0.0";
    public static final String OPERATION_NAME = "findItemsByKeywords";
    public static final String GLOBAL_ID = "EBAY-DE";
    public final static int REQUEST_DELAY = 3000;
    public final static int MAX_RESULTS = 100;
    private int maxResults;

    public EbayDriverFindItemsByKeywords() {
        this.maxResults = MAX_RESULTS;
    }

    public EbayDriverFindItemsByKeywords(int maxResults) {

        this.maxResults = maxResults;
    }

    public String getName() {

        return "";//IDriver.EBAY_DRIVER;
    }

    // Run in eBay
    @GetMapping("/run/find-items-by-keywords/{tag}")
    @ApiOperation("Search in eBay")
    public ArrayList<EbaySearchResult> run(@PathVariable(value = "tag") String tag) throws Exception {

        String address = createAddress(tag);
        print("sending request to :: ", address);
        String response = URLReader.read(address);
        print("response :: ", response);

        //process xml dump returned from EBAY
        ArrayList<EbaySearchResult> ebaySearchResults = processResponse(response);

        //Honor rate limits - wait between results
        Thread.sleep(REQUEST_DELAY);

        return ebaySearchResults;

    }

    private String createAddress(String tag) {

            //substitute token
            String address = EbayDriverFindItemsByKeywords.EBAY_FINDING_SERVICE_URI;
            address = address.replace("{version}", EbayDriverFindItemsByKeywords.SERVICE_VERSION);
            address = address.replace("{operation}", EbayDriverFindItemsByKeywords.OPERATION_NAME);
            address = address.replace("{globalId}", EbayDriverFindItemsByKeywords.GLOBAL_ID);
            address = address.replace("{applicationId}", EbayDriverFindItemsByKeywords.EBAY_APP_ID);
            address = address.replace("{keywords}", tag);
            address = address.replace("{maxresults}", "" + this.maxResults);

        return address;

    }

    private ArrayList<EbaySearchResult> processResponse(String response) throws Exception {


        XPath xpath = XPathFactory.newInstance().newXPath();
        InputStream is = new ByteArrayInputStream(response.getBytes("UTF-8"));
        DocumentBuilderFactory domFactory = DocumentBuilderFactory.newInstance();
        DocumentBuilder builder = domFactory.newDocumentBuilder();


        Document doc = builder.parse(is);
        XPathExpression ackExpression = xpath.compile("//findItemsByKeywordsResponse/ack");
        XPathExpression itemExpression = xpath.compile("//findItemsByKeywordsResponse/searchResult/item");

        String ackToken = (String) ackExpression.evaluate(doc, XPathConstants.STRING);
        print("ACK from ebay API :: ", ackToken);
        if (!ackToken.equals("Success")) {
            throw new Exception(" service returned an error");
        }

        NodeList nodes = (NodeList) itemExpression.evaluate(doc, XPathConstants.NODESET);

        ArrayList<EbaySearchResult> items = new ArrayList<>();

        for (int i = 0; i < nodes.getLength(); i++) {

            Node node = nodes.item(i);

            String itemId = (String) xpath.evaluate("itemId", node, XPathConstants.STRING);
            String title = (String) xpath.evaluate("title", node, XPathConstants.STRING);
            String itemUrl = (String) xpath.evaluate("viewItemURL", node, XPathConstants.STRING);
            String galleryUrl = (String) xpath.evaluate("galleryURL", node, XPathConstants.STRING);
            String currentPrice = (String) xpath.evaluate("sellingStatus/currentPrice", node, XPathConstants.STRING);

            print("currentPrice", currentPrice);
            print("itemId", itemId);
            print("title", title);
            print("galleryUrl", galleryUrl);

            EbaySearchResult eBaySearchResult = new EbaySearchResult();
            eBaySearchResult.setCurrentPrice(currentPrice);
            eBaySearchResult.setGalleryUrl(galleryUrl);
            eBaySearchResult.setItemId(itemId);
            eBaySearchResult.setTitle(title);
            eBaySearchResult.setItemUrl(itemUrl);

            items.add(eBaySearchResult);
        }

        is.close();

        return items;
    }

    private void print(String name, String value) {
        System.out.println(name + "::" + value);
    }

    public static void main(String[] args) throws Exception {
        EbayDriverFindItemsByKeywords driver = new EbayDriverFindItemsByKeywords();
        String tag = "Velo binding machine";
        driver.run(java.net.URLEncoder.encode(tag, "UTF-8"));

    }
}

