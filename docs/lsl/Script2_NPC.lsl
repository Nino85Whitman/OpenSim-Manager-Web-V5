integer temps_synchro = 10; 

key requestid; 
string ordre;
//**************************************************************************************************** 
reponse_web(string dataweb)
{
    list ma_liste = llCSV2List(dataweb);
//llOwnerSay("---------------------------------------");
//llOwnerSay( llList2String(ma_liste, 1));
//llOwnerSay( llList2String(ma_liste, 2));
//llOwnerSay( llList2String(ma_liste, 3));
//llOwnerSay( llList2String(ma_liste, 4));
//llOwnerSay( llList2String(ma_liste, 5));
//llOwnerSay("---------------------------------------"); 
string section0 = llStringTrim( llList2String(ma_liste, 0),STRING_TRIM);
string section1 = llStringTrim( llList2String(ma_liste, 1),STRING_TRIM);
string section2 = llStringTrim( llList2String(ma_liste, 2),STRING_TRIM);
string section3 = llStringTrim( llList2String(ma_liste, 3),STRING_TRIM);
string section4 = llStringTrim( llList2String(ma_liste, 4),STRING_TRIM);
string section5 = llStringTrim( llList2String(ma_liste, 5),STRING_TRIM);

    if( section5 == llGetKey())
    { 
        //**************************************     
        if( section0 == "Gestion_NPC")
        {             
            if(section1 == "REZ1")          {rez_objet("Particule1");}                                 
            if(section1 == "REZ2")          {rez_objet("Particule2");}   
            if(section1 == "REZ3")          {rez_objet("Particule3");}   
            if(section1 == "STOP_ALL")      {stop_all_NPC();} 
            if(section1 == "CREATE")        {commande_NPC("create "+section2+" "+section3+" "+section4);}    
            if(section1 == "REMOVE_NPC")    {commande_NPC("remove "+section2);} 
            if(section1 == "SAY")           {commande_NPC("say "+section2+" "+section3 );} 
            if(section1 == "ANIMATE_START") {commande_NPC("animate_start "+section2+" "+section3 );}
            if(section1 == "ANIMATE_STOP")  {commande_NPC("animate_stop "+section2+" "+section3 );}  
            if(section1 == "SIT")           {commande_NPC("sit "+section2+" "+section3 );} 
            if(section1 == "STAND")         {commande_NPC("stand "+section2 );} 
            if(section1 == "APPARENCE_LOAD"){commande_NPC("load "+section2+" "+section3 );}
            if(section1 == "APPARENCE_SAVE"){commande_NPC("save "+section2+" "+section3 );}
        
            if(section1 == "LISTING")       
            {
                string inventaire = "";
                integer nb_notecard = llGetInventoryNumber(INVENTORY_NOTECARD);
                integer x=0;  
                inventaire = "apparence;"+nb_notecard+";";  
                for ( x = 0; x < nb_notecard; x++)
                    { inventaire = inventaire + llGetInventoryName(INVENTORY_NOTECARD, x) + ";"; }
                integer nb_anaimation = llGetInventoryNumber(INVENTORY_ANIMATION);
                inventaire = inventaire + "animation;"+nb_anaimation+";";
                 x=0;    
                for ( x = 0; x < nb_anaimation; x++)
                    { inventaire = inventaire + llGetInventoryName(INVENTORY_ANIMATION, x) + ";"; }
                appel_web("LISTE_OBJ",inventaire);
            } 
        }  
    }     
    //**************************************
    if( section0 == "Info_NPC")
    {
       llOwnerSay(section1 + ":");
       llOwnerSay(section2);
        list listRetour =llParseString2List(section3, [";"], []); 
        integer i;
        for (i = 0; i < llGetListLength(listRetour); ++i)
        {
            llOwnerSay(  llList2String(listRetour, i));
        }
    }
    //**************************************
       
} 
//**************************************************************************************************** 
//  LES FONCTIONS
//****************************************************************************************************   
 appel_web(string parameter, string datas)
{
    string url =llGetObjectDesc();
    requestid = llHTTPRequest(url, 
        [HTTP_METHOD, "POST",HTTP_MIMETYPE, "application/x-www-form-urlencoded"],
         "parameter="+parameter+"&uuid=" + (string)llGetKey()+"&datas=" + datas+"&region="+llGetRegionName() );         
}
//****************************************************************************************************   
rez_objet(string parameter)
{
    rotation rot = llEuler2Rot(< 0, 90, 90> * DEG_TO_RAD);
    vector vec = llGetPos() + < 0.0, 0.0, 15.0>; // 15 mètres plus haut 
    vector speed = llGetVel();
    llRezAtRoot(parameter, vec, speed, rot, 10);
}
//****************************************************************************************************  
commande_NPC(string commande)
{
    llMessageLinked(LINK_ROOT, 9876543210, commande, NULL_KEY);
}
//****************************************************************************************************  
stop_all_NPC()
{
    llOwnerSay("Removing all NPCs from this scene!");
    list avies = osGetAvatarList();
    integer n;
    for(n=0;n<llGetListLength(avies);n=n+3)
    {
        //llOwnerSay(llList2String(avies,n));
        llOwnerSay("Attempting to remove "+llList2String(avies,n+2)+" with UUID "+llList2String(avies,n+0));
        osNpcRemove((key)llList2Key(avies,n));
    }
}
//**************************************************************************************************** 
//  DEBUT PROG PRINCIPAL
//**************************************************************************************************** 
default
{
    on_rez(integer params)      
    {
        appel_web("REG_WEB_NPC","");
        llOwnerSay("Demande -> Enregistrement du Gestionnaire de NPC Web");
    }
    state_entry()               {llSetTimerEvent(temps_synchro);}
    timer()                     {appel_web("TIMER","");}
    touch_start(integer number) {appel_web("LISTE_NPC","");}
    changed( integer change )  
    {
        if ( change == CHANGED_INVENTORY )
        llOwnerSay("Changement Inventaire, RECHARGER DEPUIS L'INTERFACE WEB");
    }
 //****************************************************************************************************     
    http_response(key request_id, integer status, list metadata, string body)
    { if (request_id == requestid)reponse_web(body);}
}
//**************************************************************************************************** 
//  FIN PROG PRINCIPAL
//**************************************************************************************************** 