// JavaScript Document
/*----------------------------------------------------------------------------------
             Javascript for Form Validation & misselaneous functions              
 -Suport of mask for edits. Only triger the maskValue funcion,passing             
  the edit object as parameter, in the edit's OnKeyDown event                     
                                                                                  
  By Amit Shah in INDIANIC
  TODO: suport for others masks than date                                         


usage: the main function is validateInputField().
Pass to this function the following pararmeters:
   input_obj (html control reference): A reference to the html control that contains the value to be validated;
   fieldType (mixed): -you can simply pass the fieldType in this parameter or
                      -you can pass an array with 2 elements, where the first is the fieldType and the second is extra data that you can pass alongwith that fieldType to perform the validation.
                       If you do not use the array form, the function will use default values for the parameters that could be specified in the array.
                       Bellow there's a table showing the field types and what kind of parameters they can have:
                       
 Type    -    Extra values that    -   Default values
              can be passed
              with this type
 -------------------------------------------------------------                      

   nullAllowed (boolean): a boolean specifying if this field is required or not;
   fieldCaption (string): the field caption to be displayed on the message (carefull, this is
              not the field object, only a string representing a caption);
 
Optionally pass the following last parameter:
   arr_opt: this is an array where:
     arr_opt[0] should contain a boolean that specify if the default message should be displayed when an error of type 1 (Field is Required) occoured.
     arr_opt[1] should contain a boolean that specify if the default message should be displayed when an error of type 2 (Field does not belong to the specified domain) occoured.
     arr_opt[2] should contain a window reference, that is, the browser window that is going to display the message. The script will use this reference to fire the alerts.
   this is an optional parameter, but if you specify it you must specify at least the two first parameters (you can ommit the third element (the window reference)).
   Anyway, if you do not specify, the default values in any case are:
     arr_opt[0] = true     (show messages for error of type 1)
     arr_opt[1] = true     (show messages for error of type 2)
     arr_opt[2] = window   (that is, the window that is executing this script)


----------------------------------------------------------------------------------*/

// Variables playing the role of constants. Do not change the value of these variables

// field types
var FIELD_TYPE_INT = 0;
var FIELD_TYPE_FLOAT = 1;
var FIELD_TYPE_CHAR = 2;
var FIELD_TYPE_VARCHAR = 3;
var FIELD_TYPE_TEXT = 4;
var FIELD_TYPE_DATE = 5;
var FIELD_TYPE_TIME = 6;
var FIELD_TYPE_DATETIME = 7;
var FIELD_TYPE_UNDEFINED = 8;
var FIELD_TYPE_CURRENCY = 50;
var FIELD_TYPE_MAIL = 51;



// contants for allowing or forbiden null.
var CNT_NULL = true;
var CNT_NOT_NULL = false;


// global variable that show what kind of validation error occured. You can check the value of GVAL_ERROR_TYPE after validating anything. Possible values are:
//   0: there was no error in validation.
//   1: Field is Required
//   2: Field not belong to the specified domain.
//   3: The re-type password value is different from the previous value.
var GVAL_ERROR_TYPE = 0;


/*----------------------------------------------------------------------------------------*/
/*--                       Form Validadion Routines                                     --*/
/*----------------------------------------------------------------------------------------*/

  // Use this function to validate an html input field. It will try to focus the control if validation fails.
  //function validateInputField(input_obj, fieldType, nullAllowed, fieldCaption, arr_opt)
  function validateInputField()
  {	  
    var input_obj = validateInputField.arguments[0];
    var fieldType = validateInputField.arguments[1];
    var nullAllowed = validateInputField.arguments[2];
    if(validateInputField.arguments.length >= 4)
      var fieldCaption = validateInputField.arguments[3];
    else
      var fieldCaption = null;
    if(validateInputField.arguments.length >= 5)
      var arr_opt = validateInputField.arguments[4];
    else
      var arr_opt = null;
  
    GVAL_ERROR_TYPE = 0;
    var bln_res = validateValue(input_obj.value, fieldType, nullAllowed, fieldCaption, arr_opt);
    if (bln_res)
      return true;
    else
    {
      input_obj.focus();
      return false;
    }
  }
  
  // Use this to ureceive a boolean true if the value is valid regarding the other parameters passed, or false otherwise.
  function validateValue(value, fieldTypeInfo, nullAllowed, fieldCaption, arr_opt)
  {
    GVAL_ERROR_TYPE = 0;
    var showDefaultMsg, showDefaultReqMsg, pwindow, pformat, fieldType, re;
    if(arr_opt == null)
    {
      showDefaultMsg = true;
      showDefaultReqMsg = true;
      pwindow = window;
    }
    else
    {
      showDefaultMsg = arr_opt[0];
      showDefaultReqMsg = arr_opt[1];
      if(arr_opt.length >= 3)
      {
      	pwindow = arr_opt[2];
      }
      else
      {
      	pwindow = window;
      }
    }
    
    if(typeof(fieldTypeInfo) == 'object')
    {
      fieldType = fieldTypeInfo[0];
      pformat = fieldTypeInfo[1];      
    }
    else
    {
      fieldType = fieldTypeInfo;
      pformat = null;
    }

    value = Trim(value);
    if((!nullAllowed)&&(value == ''))
	{
	  if(showDefaultReqMsg)
        pwindow.alert('The field "' + fieldCaption + '" can not be empty. Please specify a value.');
      GVAL_ERROR_TYPE = 1;  
      return(false);
    }
    else if((nullAllowed)&&(value == ''))
      return(true);

    if(fieldType == FIELD_TYPE_CURRENCY)
	{
      re = /^$|^((\d)+(.\d\d|\d)?)$/;
      if (re.test(value))
	  {
         return(true);
      }
	  else
	  {
	    if(showDefaultMsg)
          pwindow.alert('The field "' + fieldCaption + '" must contain a currency value. Use "." (dot) caracter as decimal separator. Use a maximum of two decimal digits.');
        GVAL_ERROR_TYPE = 2;
        return(false);
      }
    }
	else if(fieldType == FIELD_TYPE_MAIL)
	{
      re = /(\w+)@([\w\-]+)\.(\w+)/;
      if (re.test(value))
	  {
         return(true);
	  }	
	  else
	  {
	    if(showDefaultMsg)
           pwindow.alert('The field "' + fieldCaption + '" must contain a valid e-mail.');
        GVAL_ERROR_TYPE = 2;
        return(false);
      }
    }
	else if(fieldType == FIELD_TYPE_INT)
	{
      re = /^$|^(\d)+$/;
      if (re.test(value)) {
         return(true);
      }else {
	    if(showDefaultMsg)
          pwindow.alert('The field "' + fieldCaption + '" must contain an integer (only numeric caracters are allowed).');
          GVAL_ERROR_TYPE = 2;
        return(false);
      }
    }
	else if(fieldType == FIELD_TYPE_FLOAT)
	{
      re = /^$|^((\d)+(.(\d)+|(\d)*))$/;
      if (re.test(value)) {
         return(true);
      }else {
	    if(showDefaultMsg)
          pwindow.alert('The field "' + fieldCaption + '" must contain a number. Use "." (dot) caracter as decimal separator.');
        GVAL_ERROR_TYPE = 2;
        return(false);
      }
    }
	else if(fieldType == FIELD_TYPE_CHAR)
	{
	  var len = value.length;
      if((len == 0)||(len == 1))
        return(true);
	  else
	  {
	    if(showDefaultMsg)
          pwindow.alert('The field "' + fieldCaption + '" must contain only one caracter.');
        GVAL_ERROR_TYPE = 2;
        return(false);
      }
    }	
	else if(fieldType == FIELD_TYPE_VARCHAR)
	{
	  var len = value.length;
	  var max_len = 255;
	  if(pformat != null)
	  {
	    max_len = pformat;
	  }
      if(len <= max_len)
        return(true);
	  else
	  {
	    if(showDefaultMsg)
          pwindow.alert('The field "' + fieldCaption + '" must contain a maximun of ' + max_len.toString() + ' caracters.');
        GVAL_ERROR_TYPE = 2;
        return(false);
      }
    }
	else if(fieldType == FIELD_TYPE_DATE)
	{
	  var aux_format;
	  if(pformat == null)
	  {
	    aux_format = 1;
	  }
	  else if(pformat == 'iso')
	  {
	    aux_format = 2;
	  }

      if (ValidateDate(value, aux_format))
	  {
        return(true);
	  }
      else
      {
	    if(showDefaultMsg)
          pwindow.alert('The field "' + fieldCaption + '" must contain a date in the following format: ' + format);
        GVAL_ERROR_TYPE = 2;
        return(false);
      }
    }	
	
  }

// This function validates password fields (with retype password field)
//function validateInputPasswordFields(input_obj1, input_obj2, fieldCaption, pshowRetypeMsg, arr_opt)
function validateInputPasswordFields()
{  
	var input_obj1 = validateInputPasswordFields.arguments[0];
    var input_obj2 = validateInputPasswordFields.arguments[1];
    var fieldCaption = validateInputPasswordFields.arguments[2];
    if(validateInputPasswordFields.arguments.length >= 4)
      var pshowRetypeMsg = validateInputPasswordFields.arguments[3];
    else
      var pshowRetypeMsg = true;
    if(validateInputPasswordFields.arguments.length >= 5)
      var arr_opt = validateInputPasswordFields.arguments[4];
    else
      var arr_opt = null;
      
    var pwindow;
    GVAL_ERROR_TYPE = 0;
    
    if(arr_opt == null)
    {
      pwindow = window;
    }
    else
    {
      if(arr_opt.length >= 3)
      {
      	pwindow = arr_opt[2];
      }
      else
      {
      	pwindow = window;
      }
    }
         
    input_obj1.value = Trim(input_obj1.value);
    input_obj2.value = Trim(input_obj2.value);

	if(!validateInputField(input_obj1, [FIELD_TYPE_VARCHAR,50], CNT_NOT_NULL, fieldCaption, arr_opt))
	  return(false);
	  
	if(input_obj1.value != input_obj2.value)
	{
	  if(pshowRetypeMsg)
	  {
	    pwindow.alert("The value in 'Re-type Password' is different from the value in '" + fieldCaption + "' field. Please, write the same value in both fields.");
	  }
	  input_obj2.focus();
	  GVAL_ERROR_TYPE = 3;
	  return(false);
	}
	return(true);
}
  


/*-----------------------------------------------------------------------------------------------------------------*/
// Mask Support Functions
/*-----------------------------------------------------------------------------------------------------------------*/

function maskValue(valueCtrl, type)
{
  if(type == FIELD_TYPE_DATE)
  {
    maskDate(valueCtrl);
  }
}

/*----------------------------------------------------------------------------------------*/
function maskDate(valor_data)
{
//the dateCtrl shoud have the right lenth.
var str_data, aux, tamanho;
   aux= "";
   str_data = valor_data.value;
   tamanho = str_data.length;
   switch (tamanho){
      case 1,2:{
         aux = str_data.substr(0, 2) + "/";
         valor_data.value = aux;
         break;
      }
      case 4,5:{
         aux = str_data.substr(0, 2) + "/" + str_data.substr(3, 2) + "/";
         valor_data.value = aux;
         break;
      }
      case 6,7,8,9,10:{
         aux = str_data.substr(0, 2) + "/" + str_data.substr(3, 2) + "/" + str_data.substr(6, 4);
         valor_data.value = aux;
         break;
      }
   }
}



/*-----------------------------------------------------------------------------------------------------------------*/
// Return a value of a Radio Button Group
/*-----------------------------------------------------------------------------------------------------------------*/
function getRadioGroupValue(radioGroup) {
var i;
  if(typeof(radioGroup.length)=='undefined')
    return(radioGroup.value)
  for(i=0;i<radioGroup.length;i++){
     if(radioGroup[i].checked)
       return(radioGroup[i].value);
  }
  return(null);
}


/*-----------------------------------------------------------------------------------------------------------------*/
// Functions to handle strings for database business
/*-----------------------------------------------------------------------------------------------------------------*/

// converte uma data no formato dd/mm/aaaa para o formato postgresql: aaaa-mm-dd
function formatToIsoDate(data)
{
   return data_convertida = data.substr(6, 4) + '-' + data.substr(3, 2) + '-' + data.substr(0, 2);
}

/*----------------------------------------------------------------------------------------*/
// desconverte uma data no formato acima
function formatToBrazilDate(data)
{
   return data_desconvertida = data.substr(9, 2) + '/' + data.substr(6, 2) + '/' + data.substr(1, 4);
}





// THE CODE BELLOW WAS TAKEN FROM AN OPEN SOURCE FONT...



/******************************************************************************
 * JavaScript Validation file
 *
 * programmer: Jason Geissler
 *
 * purpose: To encapsulate the mundane date, ssn, phone number, and time validation
 *          in one file
 *
 * date: March 19, 2002
 *
 *****************************************************************************/


/******************************************************************************
 * method: ValidateSSN
 *
 * author: Jason Geissler
 *
 * date: March 19, 2002
 *
 * parameters: ssn (Social Security number)
 *
 * purpose: To validate a social security number to make sure the number
 *          is valid
 *****************************************************************************/
function ValidateSSN(ssn) {
  if((ssn.length == 11) || (ssn.length == 9)) {     // Make sure it's a valid length
    var segments = ssn.split("-")                   // Split the number into segments delimited by '-'
    if ((segments.length == 3)) {
			if ((segments[0].length == 3) && (segments[1].length == 2) && (segments[2].length == 4)) {
				for (var i = 0; i < 3; i++) {
					if (isNaN(segments[i]))                   // Check to see if the number is a valid number
						return false;
				}
				return true;
			}
    }
    else {
      if ((segments.length == 1) && (!isNaN(ssn)))  // Check to see if the number is a valid number
        return true;
    }
  }
  return false;
}

		
/******************************************************************************
 * method: ValidateTime
 *
 * author: Jason Geissler
 *
 * date: March 19, 2002
 *
 * parameters: time, formatType (1 - Standard format, 2- Military format)
 *
 * purpose: To validate a time in HH:MM format
 *****************************************************************************/
function ValidateTime(time, formatType) {
	var segments;			// Break up of the time into hours and minutes
	var hour;					// The value of the entered hour
	var minute;				// The value of the entered minute
		
	time = time.replace(".", ":");
		
	if (formatType == 1) {						                              /* Validating standard time */
		segments = time.split(":");
		
		if (segments.length == 2) {
			segments[1] = segments[1].substring(0,2);
			hour = segments[0];				                                  // Test the hour
			if ((hour > 12) || (hour < 1))  
				return false;
						
			minute = segments[1];			                                  // Test the minute
			if (( minute <= 59) && (minute >= 0)) 
				return true;
		}
			
	}
	else {												                                  /* Validating military time */
		segments = time.split(":");
		
		if (segments.length == 2) {
			hour = segments[0];				                                  // Test the hour
			if ((hour > 23) || (hour <= -1)) 
				return false;
				
			minute = segments[1];			                                  // Test the minute
			if (( minute <= 59) && (minute >= 0)) 
				return true;
		}
	}
	return false;
}	


/******************************************************************************
 * method: ValidateAdvancedTime
 *
 * author: Jason Geissler
 *
 * date: March 20, 2002
 *
 * parameters: time, formattype(1- Standard, 2- military)
 *
 * purpose: Calls the ValidateTime for hours and minutes but this also 
 *          calculates seconds. Time must be in XX:XX:XX style.
 *****************************************************************************/
function ValidateAdvancedTime(time, formatType){
	time = time.replace(".", ":");
	var newTime = time.substring(0, (time.indexOf(":") + 3)); // Strip out the seconds
	var status = ValidateTime(newTime, formatType);
	
	if(status == false) 
		return false;
		
	var seconds = time.substring(time.indexOf(":") + 4, time.length);
	if(seconds.length > 2) 
		seconds = seconds.substring(0, 2);                      // Remove any AM/PM afterwards
		
	if(!isNaN(seconds)) {			                                // Make sure its a number and it's between 0 and 59
		if((seconds <= 59) && (seconds >= 0)) 
			return true;
	}
	return false;	
}


/******************************************************************************
 * method: ValidateDate
 *
 * author: Jason Geissler
 *
 * date: March 20, 2002
 *
 * parameters: date, formattype(1- US, 2- International)
 *
 * purpose: Validates the passed in date for accuarcy supports
 *          US and international date format.
 *****************************************************************************/ 
function ValidateDate(date, formattype) {
	var segments;
	var year;
	var month;
	var day;
	var status;
	var i;
	var leapYear = false;
	
	if(formattype == 1) {                                 /* Standard time validation note this doesn't support a time */
		// check for time
		var spaceIndex = date.indexOf(" ");
		if (spaceIndex > 0) {
			time = date.substring(spaceIndex, date.length);
			date = date.substring(0, spaceIndex);
			status = ValidateAdvancedTime(time, 1);
			if (status == false) 
				return false;
		}
		// replace any '-' or '.' or "/" with ""
		for (i = 0; i < 2; i++) {
			date = date.replace("-", "/");
			date = date.replace(".", "/");
		}
		var slashIndex = date.indexOf("/");
		if(slashIndex == -1) 
			date = HandleSlashes(date);
		
		// Check to see if the date is a valid length
		// Supports MMDDYY, MMDDYYYY, (M)M/(D)D/YY, (M)M/(D)D/YYYY
		segments = date.split("/");
		month = segments[0];
		day = segments[1];
		year = segments[2];
				
		// Start testing
    status = TestYear(year);
		if(status == false) 
			return false;
			
		if (year.length == 4) 
		  leapYear = IsLeapYear(year);
				
		status = TestMonth(month);
		if(status == false) 
			return false;
				
		status = TestDay(day, month, leapYear);
		if(status == true) 
			return true;
	}
	else {														                    /* International Date Validation YYYY-MM-DD */
		if(date.length > 10) {
			var time = date.substring(10, date.length);
			status = ValidateAdvancedTime(time, 2);
			if (status == false) 
				return false;
			date = date.substring(0,10)
		} 
		// Get our date in a common format
		for (i = 0; i < 2; i++) {
			date = date.replace(".", "-");
			date = date.replace("/", "-");
		}
		
		var dashIndex = date.indexOf("-");
		
		if (dashIndex == -1) 
			date = HandleDashes(date);
				
		segments = date.split("-");
		year = segments[0];
		month = segments[1];
		day = segments[2];
		
		// Start testing
		if (year.length == 4) {
			status = TestYear(year);
			if(status == false) 
				return false;
			leapYear = IsLeapYear(year);
		}
		else 
			return false;
				
		status = TestMonth(month);
		if(status == false) 
			return false;
				
		status = TestDay(day, month, leapYear);
		if(status == true) 
			return true;
	}
	return false;
}		

		
/******************************************************************************
 * method: TestYear
 *
 * author: Jason Geissler
 *
 * date: March 21, 2002
 *
 * parameters: year
 *
 * purpose: Test for a valid year can be any number either YY or YYYY
 *****************************************************************************/
function TestYear(year) {
	// Test the year
	if((year.length == 4) || (year.length == 2)) {
	  // we won't restrict what a user wants to enter for a date since this method is generic
 		if (!isNaN(year)) 
			return true;
	}
	return false;
}


/******************************************************************************
 * method: TestMonth
 *
 * author: Jason Geissler
 *
 * date: March 21, 2002
 *
 * parameters: month
 *
 * purpose: Test for a valid month has to be MM
 *****************************************************************************/
function TestMonth(month) {
	// Test the month
	if ((isNaN(month)) || (month < 1) || (month > 12)){
		return false;
	}
	return true;
}


/******************************************************************************
 * method: TestDay
 *
 * author: Jason Geissler
 *
 * date: March 21, 2002
 *
 * parameters: day
 *
 * purpose: Test for a valid day has to be DD
 *****************************************************************************/
function TestDay(day, month, leapYear) {
	month -= 0;	// Convert the month into a Number for the case's
	
	if(!isNaN(day)) {
		switch(month) {	// Test the days for a particular month
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				if ((day >= 1) && (day <= 31)) 
					return true;
				break;
					
			case 4:
			case 6:
			case 9:
			case 11:
				if ((day >= 1) && (day <= 30)) 
					return true;
				break;
					
			case 2:
			  if(leapYear) {
			    if ((day >= 1) && (day <= 29)) 
			      return true;
			  }
				else {
					if ((day >= 1) && (day <= 28)) 
						return true;
				}
				break;
						
			default:
				break;
		}
	}	
	return false;	
}


/******************************************************************************
 * method: IsLeapYear
 *
 * author: Jason Geissler
 *
 * date: April 28, 2002
 *
 * parameters: year
 *
 * purpose: Checks to see if the year is a leap year, we can do this
 *          with 4 digit years
 *****************************************************************************/
function IsLeapYear(year) {
  var betweenYears = 4;									// We also know that there is 4 years between leap years
  var leapYear = 2000;
  year = leapYear - year;								// Set year to the difference see if it's divisible by 4
  var remainder = year % betweenYears;

  if (remainder == 0) {
    return true;
  }
  return false;
}


/******************************************************************************
 * method: HandleSlashes
 *
 * author: Jason Geissler
 *
 * date: September 12, 2002
 *
 * parameters: date
 *
 * purpose: Inserts a "/" into a date based on date size
 *****************************************************************************/
function HandleSlashes(date) {
	date = date.substring(0, 2) + "/" + date.substring(2, 4) + "/" + date.substring(4, date.length);	
	return date;
}


/******************************************************************************
 * method: HandleDashes
 *
 * author: Jason Geissler
 *
 * date: September 12, 2002
 *
 * parameters: date
 *
 * purpose: Inserts a "-" into a date based on date size
 *****************************************************************************/
function HandleDashes(date) {
	date = date.substring(0, 4) + "-" + date.substring(4, 6) + "-" + date.substring(6, date.length);
	return date;
}



// THE CODE BELLOW WAS TAKEN FROM AN OPEN SOURCE FONT

/*
==================================================================
LTrim(string) : Returns a copy of a string without leading spaces.
==================================================================
*/
function LTrim(str)
/*
   PURPOSE: Remove leading blanks from our string.
   IN: str - the string we want to LTrim
*/
{
   var whitespace = new String(" \t\n\r");

   var s = new String(str);

   if (whitespace.indexOf(s.charAt(0)) != -1) {
      // We have a string with leading blank(s)...

      var j=0, i = s.length;

      // Iterate from the far left of string until we
      // don't have any more whitespace...
      while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
         j++;

      // Get the substring from the first non-whitespace
      // character to the end of the string...
      s = s.substring(j, i);
   }
   return s;
}

/*
==================================================================
RTrim(string) : Returns a copy of a string without trailing spaces.
==================================================================
*/
function RTrim(str)
/*
   PURPOSE: Remove trailing blanks from our string.
   IN: str - the string we want to RTrim

*/
{
   // We don't want to trip JUST spaces, but also tabs,
   // line feeds, etc.  Add anything else you want to
   // "trim" here in Whitespace
   var whitespace = new String(" \t\n\r");

   var s = new String(str);

   if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
      // We have a string with trailing blank(s)...

      var i = s.length - 1;       // Get length of string

      // Iterate from the far right of string until we
      // don't have any more whitespace...
      while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
         i--;


      // Get the substring from the front of the string to
      // where the last non-whitespace character is...
      s = s.substring(0, i+1);
   }

   return s;
}

/*
=============================================================
Trim(string) : Returns a copy of a string without leading or trailing spaces
=============================================================
*/
function Trim(str)
/*
   PURPOSE: Remove trailing and leading blanks from our string.
   IN: str - the string we want to Trim

   RETVAL: A Trimmed string!
*/
{
   return RTrim(LTrim(str));
}

// Function for checking the character to character of string
function inValidCharSet(str,charset){
	var result = true;
	for (var i=0;i<str.length;i++){
		if (charset.indexOf(str.substr(i,1)) < 0){
			result = false;
			break;
		}
	}
	return result;
}
//validate Email
function IsEmail(InString) {
	if(InString != "" ) {
		if( (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(InString)) ) {
			return true;
		}
	}
	return false;
}

