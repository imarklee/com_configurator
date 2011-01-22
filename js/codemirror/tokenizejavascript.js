var tokenizeJavaScript=(function(){function nextUntilUnescaped(source,end){var escaped=false;var next;while(!source.endOfLine()){var next=source.next();if(next==end&&!escaped){return false}escaped=!escaped&&next=="\\"}return escaped}var keywords=function(){function result(type,style){return{type:type,style:"js-"+style}}var keywordA=result("keyword a","keyword");var keywordB=result("keyword b","keyword");var keywordC=result("keyword c","keyword");var operator=result("operator","keyword");var atom=result("atom","atom");return{"if":keywordA,"while":keywordA,"with":keywordA,"else":keywordB,"do":keywordB,"try":keywordB,"finally":keywordB,"return":keywordC,"break":keywordC,"continue":keywordC,"new":keywordC,"delete":keywordC,"throw":keywordC,"in":operator,"typeof":operator,"instanceof":operator,"var":result("var","keyword"),"function":result("function","keyword"),"catch":result("catch","keyword"),"for":result("for","keyword"),"switch":result("switch","keyword"),"case":result("case","keyword"),"default":result("default","keyword"),"true":atom,"false":atom,"null":atom,"undefined":atom,"NaN":atom,"Infinity":atom}}();var isOperatorChar=/[+\-*&%=<>!?|]/;var isHexDigit=/[0-9A-Fa-f]/;var isWordChar=/[\w\$_]/;function jsTokenState(inside,regexp){return function(source,setState){var newInside=inside;var type=jsToken(inside,regexp,source,function(c){newInside=c});var newRegexp=type.type=="operator"||type.type=="keyword c"||type.type.match(/^[\[{}\(,;:]$/);if(newRegexp!=regexp||newInside!=inside){setState(jsTokenState(newInside,newRegexp))}return type}}function jsToken(inside,regexp,source,setInside){function readHexNumber(){source.next();source.nextWhileMatches(isHexDigit);return{type:"number",style:"js-atom"}}function readNumber(){source.nextWhileMatches(/[0-9]/);if(source.equals(".")){source.next();source.nextWhileMatches(/[0-9]/)}if(source.equals("e")||source.equals("E")){source.next();if(source.equals("-")){source.next()}source.nextWhileMatches(/[0-9]/)}return{type:"number",style:"js-atom"}}function readWord(){source.nextWhileMatches(isWordChar);var word=source.get();var known=keywords.hasOwnProperty(word)&&keywords.propertyIsEnumerable(word)&&keywords[word];return known?{type:known.type,style:known.style,content:word}:{type:"variable",style:"js-variable",content:word}}function readRegexp(){nextUntilUnescaped(source,"/");source.nextWhileMatches(/[gi]/);return{type:"regexp",style:"js-string"}}function readMultilineComment(start){var newInside="/*";var maybeEnd=(start=="*");while(true){if(source.endOfLine()){break}var next=source.next();if(next=="/"&&maybeEnd){newInside=null;break}maybeEnd=(next=="*")}setInside(newInside);return{type:"comment",style:"js-comment"}}function readOperator(){source.nextWhileMatches(isOperatorChar);return{type:"operator",style:"js-operator"}}function readString(quote){var endBackSlash=nextUntilUnescaped(source,quote);setInside(endBackSlash?quote:null);return{type:"string",style:"js-string"}}if(inside=='"'||inside=="'"){return readString(inside)}var ch=source.next();if(inside=="/*"){return readMultilineComment(ch)}else{if(ch=='"'||ch=="'"){return readString(ch)}else{if(/[\[\]{}\(\),;\:\.]/.test(ch)){return{type:ch,style:"js-punctuation"}}else{if(ch=="0"&&(source.equals("x")||source.equals("X"))){return readHexNumber()}else{if(/[0-9]/.test(ch)){return readNumber()}else{if(ch=="/"){if(source.equals("*")){source.next();return readMultilineComment(ch)}else{if(source.equals("/")){nextUntilUnescaped(source,null);return{type:"comment",style:"js-comment"}}else{if(regexp){return readRegexp()}else{return readOperator()}}}}else{if(isOperatorChar.test(ch)){return readOperator()}else{return readWord()}}}}}}}}return function(source,startState){return tokenizer(source,startState||jsTokenState(false,true))}})();