<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '1G');
error_reporting(E_ALL);

use Magento\Framework\App\Bootstrap;
include('app/bootstrap.php');
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$url = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $url->get('\Magento\Store\Model\StoreManagerInterface');
$mediaurl= $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');

$directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
$rootPath  =  $directory->getRoot();
$fileName = $rootPath.'/categoriescreatename.csv';
$websiteId = $storeManager->getWebsite()->getWebsiteId();
'websiteId: '.$websiteId." ";
$store = $storeManager->getStore();
$storeId = $store->getStoreId();
'storeId: '.$storeId." ";
$rootNodeId = $store->getRootCategoryId();
'rootNodeId: '.$rootNodeId." ";
/// Get Root Category
$rootCat = $objectManager->get('Magento\Catalog\Model\Category');
$cat_info = $rootCat->load($rootNodeId);
$handle = fopen($fileName,'r');
   		
   			if (($handle = fopen($fileName, "r")) !== FALSE) {

					   

					    $len = count(file($fileName));
					    $headerLine = true;
					   

					    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 	 
							
					   		if($headerLine) { 
					   			// remove header
					   			$headerLine = false; 
					   		}

					    	else {

					    		try { 
					    				$category = $data[0];
					    				$categoriesString = empty($category) ? '' : $category;
					    				$categoryProcessor=$objectManager->create('\Magento\CatalogImportExport\Model\Import\Product\CategoryProcessor');
					    				$categoryIds = $categoryProcessor->upsertCategories($category, ',');
					    				echo "<pre>";
					    				print_r($categoryIds);
					    				echo "</pre>";
					    				
					    			}
							    catch(Exception $e)
							    {
							         print_r($e->getMessage());
							        die('in exception');
							    }

							    	}
					    }
					    
					  


					}




?>