
key requestid; 
key npc;

default
{
    
    state_entry()
    {

    }  

    link_message(integer sender_num, integer num, string msg, key id)
    {
        string url =llGetObjectDesc();
        if (msg != "")
        {
            list commands = llParseString2List(msg, [ " " ], []);
            string msg0 = llList2String(commands, 0);
            string msg1 = llList2String(commands, 1);            
            string msg2 = llList2String(commands, 2);
            string msg3 = llList2String(commands, 3);
             llOwnerSay(msg);
//*****************************************************************************         
            if (msg0 == "create")
            {
                if (msg1 != "" )
                {
                    string firstname ="Avatar";
                    string lastname ="NPC";
                    string notecardName = msg1;
                    
                    if (msg2 != "" && msg3 != "")
                    {                        
                        list listname =llParseString2List(msg2, [";"], []); 
                        firstname = llList2String(listname,0);
                        lastname = llList2String(listname,1);   
                        list listcoord =llParseString2List(msg3, [";"], []); 
                        vector pos = <(integer)llList2String(listcoord,0),(integer)llList2String(listcoord,1),(integer)llList2String(listcoord,2)>;
                        npc = osNpcCreate(firstname,lastname, llGetPos() + pos, notecardName);
                        llOwnerSay("Created npc from notecard " + notecardName);                      
                    }
                    else
                    {
                        npc = osNpcCreate(firstname,lastname, llGetPos() + <5, 5, 5>, notecardName);
                        llOwnerSay("Created npc from notecard " + notecardName);
                    }
                     llOwnerSay("Created npc UUID: " + npc);
                    requestid = llHTTPRequest(url, [HTTP_METHOD, "POST",HTTP_MIMETYPE,"application/x-www-form-urlencoded"],
                                "parameter=NPC_CREATE&uuid="+npc+"&firstname="+firstname+"&lastname="+lastname+"&region="+llGetRegionName());
                }
                else
                {  llOwnerSay("Usage: create <notecard-name>");}
            } 
//*****************************************************************************         
            else if (msg0 == "remove" && msg1 != "" )
            {
                osNpcSay(msg1, "Goodbye !!!");
                osNpcRemove(msg1);
            }  
//*****************************************************************************         
            else if (msg0 == "say" && msg1 != ""&& msg2 != "")
            {
                osNpcSay(msg1,msg2);
            }   
//*****************************************************************************         
            else if (msg0 == "move")
            {
                if (msg1 != "" && msg2 != "" && npc != NULL_KEY)
                {                
                    vector delta = <(integer)msg1, (integer)msg2, 0>;
                    if (msg3 != "")
                    {
                        delta.z = (integer)msg3;
                    }
                    osNpcMoveTo(npc, osNpcGetPos(npc) + delta);                    
                }                            
                else
                {llOwnerSay("Usage: move <x> <y> [<z>]");}
            }   
//*****************************************************************************
            else if (msg0 == "moveto")
            {
                if (msg1 != "" && msg2 != "" && npc != NULL_KEY)
                {                
                    vector pos = <(integer)msg1, (integer)msg2, 0>;
                    if (msg3 != "")
                    {pos.z = (integer)msg3;}
                    osNpcMoveTo(npc, pos);                    
                }                            
                else
                {
                    llOwnerSay("Usage: move <x> <y> [<z>]");
                }
            }            
//*****************************************************************************
            else if (msg0 == "movetarget" && npc != NULL_KEY)
            {
                osNpcMoveToTarget(npc, llGetPos() + <9,9,5>, OS_NPC_FLY|OS_NPC_LAND_AT_TARGET);
            }
//*****************************************************************************
            else if (msg0 == "movetargetnoland" && npc != NULL_KEY)
            {
                osNpcMoveToTarget(npc, llGetPos() + <9,9,5>, OS_NPC_FLY);
            }            
//*****************************************************************************
            else if (msg0 == "movetargetwalk" && npc != NULL_KEY)
            {
                osNpcMoveToTarget(npc, llGetPos() + <9,9,0>, OS_NPC_NO_FLY);           
            }
//*****************************************************************************         
            else if (msg0 == "rot" && npc != NULL_KEY)
            {
                vector xyz_angles = <0,0,90>; // This is to define a 1 degree change
                vector angles_in_radians = xyz_angles * DEG_TO_RAD; // Change to Radians
                rotation rot_xyzq = llEuler2Rot(angles_in_radians); // Change to a Rotation                
                rotation rot = osNpcGetRot(npc);
                osNpcSetRot(npc, rot * rot_xyzq);
            }
//*****************************************************************************
            else if (msg0 == "rotabs" && msg1 != "")
            {
                vector xyz_angles = <0, 0, (integer)msg1>;
                vector angles_in_radians = xyz_angles * DEG_TO_RAD; // Change to Radians
                rotation rot_xyzq = llEuler2Rot(angles_in_radians); // Change to a Rotation                
                osNpcSetRot(npc, rot_xyzq);                
            }
//*****************************************************************************         
            else if (msg0 == "animate_start" && msg1 != "" && msg2 != "")
            {
                osAvatarPlayAnimation(msg1,msg2);
            }  
//*****************************************************************************         
            else if (msg0 == "animate_stop" && msg1 != "" && msg2 != "")
            {
                osAvatarStopAnimation(msg1,msg2);
            }                                                  
//*****************************************************************************         
            else if (msg0 == "save" && msg1 != "" && msg2 != "")
            {
                osNpcSaveAppearance(msg1, msg2);
                llOwnerSay("Saved appearance " + msg2 + " to " + npc);                
            }
//*****************************************************************************
            else if (msg0 == "load" && msg1 != "" && msg2 != "")
            {
                osNpcLoadAppearance(msg1, msg2);
                llOwnerSay("Loaded appearance " + msg2 + " to " + npc);
            }
//*****************************************************************************
            else if (msg0 == "clone")
            {
                if (msg1 != "")
                {
                    osOwnerSaveAppearance(msg1);
                    llOwnerSay("Cloned your appearance to " + msg1);
                }
                else
                { llOwnerSay("Usage: clone <notecard-name-to-save>");}
            }
//*****************************************************************************
            else if (msg0 == "stop" && npc != NULL_KEY)
            {
                osNpcStopMoveToTarget(npc);
            }
//*****************************************************************************
            else if (msg0 == "sit" && msg1 != "" && msg2 != "")
            {
                osNpcSit(msg1, msg2, OS_NPC_SIT_NOW);
            }
//*****************************************************************************         
            else if (msg0 == "stand" && msg1 != "")
            {
                osNpcStand(msg1);
            }
//*****************************************************************************
            else
            {llOwnerSay("I don't understand [" + msg + "]");}
        }   
    }   
    
    http_response(key request_id, integer status, list metadata, string body)
    {
        if (request_id == requestid)
        llOwnerSay(body);
    }
}