function tokenizer(source,state){function isWhiteSpace(ch){return ch!="\n"&&/^[\s\u00a0]*$/.test(ch)}var tokenizer={state:state,take:function(type){if(typeof(type)=="string"){type={style:type,type:type}}type.content=(type.content||"")+source.get();if(!/\n$/.test(type.content)){source.nextWhile(isWhiteSpace)}type.value=type.content+source.get();return type},next:function(){if(!source.more()){throw StopIteration}var type;if(source.equals("\n")){source.next();return this.take("whitespace")}if(source.applies(isWhiteSpace)){type="whitespace"}else{while(!type){type=this.state(source,function(s){tokenizer.state=s})}}return this.take(type)}};return tokenizer};