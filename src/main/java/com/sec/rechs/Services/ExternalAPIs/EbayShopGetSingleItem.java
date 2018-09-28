package com.sec.rechs.Services.ExternalAPIs;

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
@RequestMapping("/api/shop")
public class EbayShopGetSingleItem {

    public final static String EBAY_APP_ID = "AhmedAlA-RECHSMSC-PRD-68bbc5abd-b7b36a04";
    public final static String EBAY_FINDING_SERVICE_URI = "http://open.api.ebay.com/shopping?callname="
            + "{callName}&"
            + "responseencoding=XML&"
            + "appid={applicationId}&"
            + "siteid={siteId}&"
            + "version={version}&"
            + "IncludeSelector={selectors}&"
            + "ItemID={itemId}";
    public static final String SERVICE_VERSION = "1.0.0";
    public static final String OPERATION_NAME = "GetSingleItem";
    public static final String GLOBAL_ID = "EBAY-US";
    public final static int REQUEST_DELAY = 3000;
    public final static int MAX_RESULTS = 10;
    private int maxResults;

    public EbayShopGetSingleItem() {
        this.maxResults = MAX_RESULTS;
    }

    public EbayShopGetSingleItem(int maxResults) {

        this.maxResults = maxResults;
    }

    public String getName() {

        return "";//IDriver.EBAY_DRIVER;
    }

    // Run in eBay
    @GetMapping("/run/get-single-item/{itemId}")
    @ApiOperation("Search in eBay - GetSingleItem")
    public ArrayList<EbaySearchResult> run(@PathVariable(value = "itemId") String itemId) throws Exception {

        String address = createAddress(itemId);
        print("sending request to :: ", address);
        String response = URLReader.read(address);
        print("response :: ", response);

        //process xml dump returned from EBAY
        ArrayList<EbaySearchResult> ebaySearchResults = processResponse(response);

        //Honor rate limits - wait between results
        Thread.sleep(REQUEST_DELAY);

        return ebaySearchResults;

    }

    private String createAddress(String searchToken) {

            //substitute token
            String address = EbayShopGetSingleItem.EBAY_FINDING_SERVICE_URI;
            address = address.replace("{version}", "967");
            address = address.replace("{callName}", EbayShopGetSingleItem.OPERATION_NAME);
            address = address.replace("{siteId}", "77");
            address = address.replace("{applicationId}", EbayShopGetSingleItem.EBAY_APP_ID);
            address = address.replace("{itemId}", searchToken);
            address = address.replace("{selectors}", "Description,ItemSpecifics,ShippingCosts");
            address = address.replace("{maxresults}", "" + this.maxResults);

        return address;

    }

    private ArrayList<EbaySearchResult> processResponse(String response) throws Exception {


        XPath xpath = XPathFactory.newInstance().newXPath();
        InputStream inputStream = new ByteArrayInputStream(response.getBytes("UTF-8"));
        DocumentBuilderFactory domFactory = DocumentBuilderFactory.newInstance();
        DocumentBuilder builder = domFactory.newDocumentBuilder();


        Document doc = builder.parse(inputStream);
        XPathExpression ackExpression = xpath.compile("//GetSingleItemResponse/Ack");
        XPathExpression itemExpression = xpath.compile("//GetSingleItemResponse/Item");

        String ackToken = (String) ackExpression.evaluate(doc, XPathConstants.STRING);
        print("ACK from ebay API :: ", ackToken);
        if (!ackToken.equals("Success")) {
            throw new Exception(" service returned an error");
        }

        NodeList nodes = (NodeList) itemExpression.evaluate(doc, XPathConstants.NODESET);

        ArrayList<EbaySearchResult> items = new ArrayList<>();

        for (int i = 0; i < nodes.getLength(); i++) {

            Node node = nodes.item(i);

            String itemId = (String) xpath.evaluate("ItemID", node, XPathConstants.STRING);
            String description = (String) xpath.evaluate("Description", node, XPathConstants.STRING);
            String itemSpecifics = (String) xpath.evaluate("ItemSpecifics", node, XPathConstants.STRING);
            //String galleryUrl = (String) xpath.evaluate("galleryURL", node, XPathConstants.STRING);
            String brandName = (String) xpath.evaluate("ItemSpecifics/NameValueList/Value", node, XPathConstants.STRING);

//            print("currentPrice", currentPrice);
//            print("itemId", itemId);
//            print("title", title);
//            print("galleryUrl", galleryUrl);

            EbaySearchResult eBaySearchResult = new EbaySearchResult();
            //eBaySearchResult.setCurrentPrice(currentPrice);
            //eBaySearchResult.setGalleryUrl(galleryUrl);
            eBaySearchResult.setItemId(itemId);
            eBaySearchResult.setTitle(brandName);
            //eBaySearchResult.setItemUrl(itemUrl);

            items.add(eBaySearchResult);
        }

        inputStream.close();

        return items;
    }

    private void print(String name, String value) {
        System.out.println(name + "::" + value);
    }

    public static void main(String[] args) throws Exception {
        EbayShopGetSingleItem driver = new EbayShopGetSingleItem();
        String tag = "Velo binding machine";
        driver.run(java.net.URLEncoder.encode(tag, "UTF-8"));

    }
}

