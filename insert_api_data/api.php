<?php

$curl = curl_init();

$headers = [
    "Authorization: Bearer tRkA4ScjAp7FMSKjr5nS_Dku61OS2MxOdPLw4h2APDa-GLeCdta42OoflWS0FwxfWGZQxy0sF5h3xNL-w3bFkWT9BYlhfWw_wW4cxQ8kuWYKKlKXgPiB2MEWf8quxOBODqydFuQ8bZhHOAecAEYC5R4_bWtEJT3fAi7r-A8RmTntUIOPKnZeJs87kj1WFv_OTe7u8vYoANdU__g2ULcs8BAcd9QIqeqSbv7k375CqEzKTL9xyJOV8YXDChbMIXg4DT33UFXkFuAyMV-ESHWR0BbmgM_lD1GvP6xfnXsv_y0z4DC_7Aa7kISVg7kit1-pI0A__hiWv4BjeEBGSHPpcqSnwBcifepOU4BiAgYUsK2YwpoyjtH8CZmNH-dqEu7YnE8TUHjH6z29WGB3uI32rSOYxaAxGptFsXoIZUB51yzblfPfyzhOwSraC-Mg1eD5J-2tleQwnj6Kvz3YBj8rlQwqN2ghLLatvHJPHIiUfLK5u78vTItQe6U3oq3I4IhRNa3GA6PmEQbwzUSWrySzXy-uBC9fNl3xybujnlmdIKtifP-I-gTD8GqCbiPSa_5BX4-ty7X6QttgfyMTAjxe8rU1mvwETmVMUUUr3qB0TiM8h_AbZdmZfaOBT6EHejlF7h1q-X6ZHTmkjN12q2XLDb1w6bHqMw_rz2udboGVH3jHO0P4Pz1ujww6bbucWCIStR8G0T9kAOkyhFLxh4tgNjrLDA3TOH73FNTkfQLR_TZI-Gwl7vNrHmAtKkFKVL_BPzYtmJfj4NvJzuGClA_JdiKFXSYHc7FqPejX8OSemlpd1QIEFA1ySpXSKDTByUiHK1yKMjYEhZVfo0sXUCfaZNNFWlma_rHHJyYV4P5ucaTZ4n3FEGF7Ze-MFdeMIeTb0Uwb1X4FLFULhyOswvZqi75ubwpAxdu6Wf8iRJMaPdQtfgf1_AUPlh_sqLo7hMWNt5dOiDDZyshTFCn6wrPPUDS13z3xbX8r7jkMqIkbUnBF77nBxWJeYpsgjJXfb0tJqbMWriBMuyZMwrbUVlg77f9hu6y4m3mn5OMKwcJkuBo"
];
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/DB/CustomQuery?key=IWSUsers',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => $headers,
  CURLOPT_POSTFIELDS => 'grant_type=refresh_token&database=G&RWillsVision&username=MohanW&password=G&RWills90',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;