(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[3],{"749b":function(o,s,r){"use strict";r.r(s);var e=function(){var o=this,s=o.$createElement,r=o._self._c||s;return r("div",[r("bodyTabs",{attrs:{titulo:"Grupo de Usuários"}},[r("template",{slot:"tabHeader"},[r("q-tab",{attrs:{slot:"title",default:"",name:"tab-1",icon:"folder_shared",label:"Cadastro"},slot:"title"}),r("q-tab",{directives:[{name:"show",rawName:"v-show",value:o.grupoUsuario.grupoUsuario,expression:"grupoUsuario.grupoUsuario"}],attrs:{slot:"title",name:"tab-2",icon:"perm data setting",label:"Permissões"},slot:"title"})],1),r("template",{slot:"tabPanel"},[r("q-tab-panel",{attrs:{name:"tab-1"}},[r("form",{on:{submit:function(s){return s.preventDefault(),o.salvarAlterar(s)}}},[r("div",{staticClass:"row barraBotoes"},[r("barra-de-botoes",{attrs:{id:o.grupoUsuario.grupoUsuario,possoGravar:o.possoGravarGrupoUsuario,possoAlterar:o.possoAlterarGrupoUsuario,possoExcluir:o.possoExcluirGrupoUsuario},on:{reset:o.reset,excluir:o.excluir,submit:o.salvarAlterar}})],1),r("div",{staticClass:"row"},[r("div",{staticClass:"col-md-6"},[r("q-input",{staticClass:"form-input",attrs:{hint:"Obrigatório",error:o.$v.grupoUsuario.codigo.$error,"error-message":o.errorCodigo,label:"Código",autocomplete:"off",type:"text",required:"",name:"codigo"},on:{blur:function(s){return o.$v.grupoUsuario.codigo.$touch()}},model:{value:o.grupoUsuario.codigo,callback:function(s){o.$set(o.grupoUsuario,"codigo",s)},expression:"grupoUsuario.codigo"}})],1),r("div",{staticClass:"col-md-6"},[r("q-input",{staticClass:"form-input",attrs:{hint:"Obrigatório",error:o.$v.grupoUsuario.descricao.$error,"error-message":"Preencha a descrição do grupo",label:"Descrição",autocomplete:"off",type:"text",required:"",name:"codigo"},on:{input:function(s){return o.$v.grupoUsuario.descricao.$touch()}},model:{value:o.grupoUsuario.descricao,callback:function(s){o.$set(o.grupoUsuario,"descricao",s)},expression:"grupoUsuario.descricao"}})],1)])])]),r("q-tab-panel",{attrs:{name:"tab-2"}},[r("form",{on:{submit:function(s){return s.preventDefault(),o.salvarAlterar(s)}}},[r("div",{staticClass:"row barraBotoes"},[r("div",{staticClass:"col-md-6 linhaBotoes"},[o.possoGravarGrupoUsuario||o.possoAlterarGrupoUsuario?r("q-btn",{attrs:{small:"",type:"submit",icon:"save"}},[o._v("Salvar")]):o._e()],1)]),r("q-list",[r("q-expansion-item",{attrs:{icon:"settings",label:"Sistema"}},[r("q-expansion-item",{attrs:{icon:"person",label:"Usuários","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.usuario,callback:function(s){o.$set(o.grupoUsuario.permissoes,"usuario",s)},expression:"grupoUsuario.permissoes.usuario"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.usuario,callback:function(s){o.$set(o.grupoUsuario.permissoes,"usuario",s)},expression:"grupoUsuario.permissoes.usuario"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.usuario,callback:function(s){o.$set(o.grupoUsuario.permissoes,"usuario",s)},expression:"grupoUsuario.permissoes.usuario"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.usuario,callback:function(s){o.$set(o.grupoUsuario.permissoes,"usuario",s)},expression:"grupoUsuario.permissoes.usuario"}})],1)])]),r("q-expansion-item",{attrs:{icon:"supervisor_account",label:"Grupo de Usuários","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-md-3 col-sm-3 col-xs-12"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.grupoUsuario,callback:function(s){o.$set(o.grupoUsuario.permissoes,"grupoUsuario",s)},expression:"grupoUsuario.permissoes.grupoUsuario"}})],1),r("div",{staticClass:"col-md-3 col-sm-3 col-xs-12"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.grupoUsuario,callback:function(s){o.$set(o.grupoUsuario.permissoes,"grupoUsuario",s)},expression:"grupoUsuario.permissoes.grupoUsuario"}})],1),r("div",{staticClass:"col-md-3 col-sm-3 col-xs-12"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.grupoUsuario,callback:function(s){o.$set(o.grupoUsuario.permissoes,"grupoUsuario",s)},expression:"grupoUsuario.permissoes.grupoUsuario"}})],1),r("div",{staticClass:"col-md-3 col-sm-3 col-xs-12"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.grupoUsuario,callback:function(s){o.$set(o.grupoUsuario.permissoes,"grupoUsuario",s)},expression:"grupoUsuario.permissoes.grupoUsuario"}})],1)])])],1),r("q-expansion-item",{attrs:{icon:"folder_shared",label:"Cadastros"}},[r("q-expansion-item",{attrs:{icon:"fas fa-file-contract",label:"Tipos de Documentos","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.tipoDocumento,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoDocumento",s)},expression:"grupoUsuario.permissoes.tipoDocumento"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.tipoDocumento,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoDocumento",s)},expression:"grupoUsuario.permissoes.tipoDocumento"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.tipoDocumento,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoDocumento",s)},expression:"grupoUsuario.permissoes.tipoDocumento"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.tipoDocumento,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoDocumento",s)},expression:"grupoUsuario.permissoes.tipoDocumento"}})],1)])]),r("q-expansion-item",{attrs:{icon:"fas fa-envelope",label:"Tipos de Correspondências","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.tipoCorrespondencia,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoCorrespondencia",s)},expression:"grupoUsuario.permissoes.tipoCorrespondencia"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.tipoCorrespondencia,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoCorrespondencia",s)},expression:"grupoUsuario.permissoes.tipoCorrespondencia"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.tipoCorrespondencia,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoCorrespondencia",s)},expression:"grupoUsuario.permissoes.tipoCorrespondencia"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.tipoCorrespondencia,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoCorrespondencia",s)},expression:"grupoUsuario.permissoes.tipoCorrespondencia"}})],1)])]),r("q-expansion-item",{attrs:{icon:"attach_money",label:"Tipos de Cobranças","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.tipoCobranca,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoCobranca",s)},expression:"grupoUsuario.permissoes.tipoCobranca"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.tipoCobranca,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoCobranca",s)},expression:"grupoUsuario.permissoes.tipoCobranca"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.tipoCobranca,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoCobranca",s)},expression:"grupoUsuario.permissoes.tipoCobranca"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.tipoCobranca,callback:function(s){o.$set(o.grupoUsuario.permissoes,"tipoCobranca",s)},expression:"grupoUsuario.permissoes.tipoCobranca"}})],1)])]),r("q-expansion-item",{attrs:{icon:"fas fa-map-marked-alt",label:"Endereços","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.endereco,callback:function(s){o.$set(o.grupoUsuario.permissoes,"endereco",s)},expression:"grupoUsuario.permissoes.endereco"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.endereco,callback:function(s){o.$set(o.grupoUsuario.permissoes,"endereco",s)},expression:"grupoUsuario.permissoes.endereco"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.endereco,callback:function(s){o.$set(o.grupoUsuario.permissoes,"endereco",s)},expression:"grupoUsuario.permissoes.endereco"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.endereco,callback:function(s){o.$set(o.grupoUsuario.permissoes,"endereco",s)},expression:"grupoUsuario.permissoes.endereco"}})],1)])]),r("q-expansion-item",{attrs:{icon:"work_outline",label:"Setores Internos","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.setor,callback:function(s){o.$set(o.grupoUsuario.permissoes,"setor",s)},expression:"grupoUsuario.permissoes.setor"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.setor,callback:function(s){o.$set(o.grupoUsuario.permissoes,"setor",s)},expression:"grupoUsuario.permissoes.setor"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.setor,callback:function(s){o.$set(o.grupoUsuario.permissoes,"setor",s)},expression:"grupoUsuario.permissoes.setor"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.setor,callback:function(s){o.$set(o.grupoUsuario.permissoes,"setor",s)},expression:"grupoUsuario.permissoes.setor"}})],1)])]),r("q-expansion-item",{attrs:{icon:"fas fa-file-alt",label:"Protocolo de Entrada","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.protocoloEntrada,callback:function(s){o.$set(o.grupoUsuario.permissoes,"protocoloEntrada",s)},expression:"grupoUsuario.permissoes.protocoloEntrada"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.protocoloEntrada,callback:function(s){o.$set(o.grupoUsuario.permissoes,"protocoloEntrada",s)},expression:"grupoUsuario.permissoes.protocoloEntrada"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.protocoloEntrada,callback:function(s){o.$set(o.grupoUsuario.permissoes,"protocoloEntrada",s)},expression:"grupoUsuario.permissoes.protocoloEntrada"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.protocoloEntrada,callback:function(s){o.$set(o.grupoUsuario.permissoes,"protocoloEntrada",s)},expression:"grupoUsuario.permissoes.protocoloEntrada"}})],1)])]),r("q-expansion-item",{attrs:{icon:"fas fa-map-marked-alt",label:"Rotas","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.rota,callback:function(s){o.$set(o.grupoUsuario.permissoes,"rota",s)},expression:"grupoUsuario.permissoes.rota"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.rota,callback:function(s){o.$set(o.grupoUsuario.permissoes,"rota",s)},expression:"grupoUsuario.permissoes.rota"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.rota,callback:function(s){o.$set(o.grupoUsuario.permissoes,"rota",s)},expression:"grupoUsuario.permissoes.rota"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.rota,callback:function(s){o.$set(o.grupoUsuario.permissoes,"rota",s)},expression:"grupoUsuario.permissoes.rota"}})],1)])]),r("q-expansion-item",{attrs:{icon:"move_to_inbox",label:"Malotes","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.malote,callback:function(s){o.$set(o.grupoUsuario.permissoes,"malote",s)},expression:"grupoUsuario.permissoes.malote"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.malote,callback:function(s){o.$set(o.grupoUsuario.permissoes,"malote",s)},expression:"grupoUsuario.permissoes.malote"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.malote,callback:function(s){o.$set(o.grupoUsuario.permissoes,"malote",s)},expression:"grupoUsuario.permissoes.malote"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.malote,callback:function(s){o.$set(o.grupoUsuario.permissoes,"malote",s)},expression:"grupoUsuario.permissoes.malote"}})],1)])]),r("q-expansion-item",{attrs:{icon:"mail_outline",label:"Correspondências","header-inset-level":1,"content-inset-level":2}},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"abrir",label:"Abrir"},model:{value:o.grupoUsuario.permissoes.correspondencia,callback:function(s){o.$set(o.grupoUsuario.permissoes,"correspondencia",s)},expression:"grupoUsuario.permissoes.correspondencia"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"inserir",label:"Salvar"},model:{value:o.grupoUsuario.permissoes.correspondencia,callback:function(s){o.$set(o.grupoUsuario.permissoes,"correspondencia",s)},expression:"grupoUsuario.permissoes.correspondencia"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"alterar",label:"Alterar"},model:{value:o.grupoUsuario.permissoes.correspondencia,callback:function(s){o.$set(o.grupoUsuario.permissoes,"correspondencia",s)},expression:"grupoUsuario.permissoes.correspondencia"}})],1),r("div",{staticClass:"col-3"},[r("q-toggle",{staticClass:"toggleGrupoUsuario",attrs:{val:"excluir",label:"Excluir"},model:{value:o.grupoUsuario.permissoes.correspondencia,callback:function(s){o.$set(o.grupoUsuario.permissoes,"correspondencia",s)},expression:"grupoUsuario.permissoes.correspondencia"}})],1)])])],1)],1)],1)])],1)],2),r("lista-de-registros")],1)},a=[],i=(r("8e6e"),r("8a81"),r("ac6a"),r("cadf"),r("06db"),r("456d"),r("9523")),t=r.n(i),u=(r("f751"),r("bbff")),l=r("d335"),c=r("2f62"),p=function(){var o=this,s=o.$createElement,r=o._self._c||s;return r("lista-de-registros",{ref:"listaDeRegistros",attrs:{labelHeader:"Grupos de Usuários"},on:{atualizaLista:o.atualizaLista}},[r("template",{slot:"qItem"},o._l(o.getRegistros,(function(s,e){return r("q-item",{key:e,staticClass:"item-lista",class:e%2?"bg-blue-grey-1":"bg-blue-grey-2",attrs:{multiline:"",item:"",to:{name:"alterarGrupoUsuario",params:{id:s.grupoUsuario}},exact:""}},[r("q-item-label",[r("q-item-section",{attrs:{header:""}},[o._v(" "+o._s(s.codigo))]),s.descricao?r("q-item-section",{attrs:{caption:""}},[o._v(o._s(s.descricao))]):o._e()],1)],1)})),1)],2)},n=[],g=r("dbcf"),m=r("0da6"),d=(r("6b54"),r("2397"),r("970b")),U=r.n(d),v=r("5bc3"),b=r.n(v),f=r("ed6d"),C=r.n(f),h=r("6b58"),x=r.n(h),q=r("36c6"),$=r.n(q),G=r("5c12");function k(o){var s=y();return function(){var r,e=$()(o);if(s){var a=$()(this).constructor;r=Reflect.construct(e,arguments,a)}else r=e.apply(this,arguments);return x()(this,r)}}function y(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(o){return!1}}var w=function(o){C()(r,o);var s=k(r);function r(){return U()(this,r),s.apply(this,arguments)}return b()(r,null,[{key:"procura",value:function(o,s,r){return this.get("grupousuarios",{params:{busca:o,inicio:s,fim:r}})}},{key:"lista",value:function(){return this.get("grupousuarios/lista")}},{key:"seleciona",value:function(o){return this.get("grupousuarios/grupousuario/".concat(o))}},{key:"grava",value:function(o){return this.post("grupousuarios/grupousuario",o)}},{key:"altera",value:function(o){return this.put("grupousuarios/grupousuario/".concat(o.grupoUsuario),o)}},{key:"apaga",value:function(o){return this.delete("grupousuarios/grupousuario/".concat(o))}}]),r}(G["a"]),E=w;function O(o,s){var r=Object.keys(o);if(Object.getOwnPropertySymbols){var e=Object.getOwnPropertySymbols(o);s&&(e=e.filter((function(s){return Object.getOwnPropertyDescriptor(o,s).enumerable}))),r.push.apply(r,e)}return r}function A(o){for(var s=1;s<arguments.length;s++){var r=null!=arguments[s]?arguments[s]:{};s%2?O(Object(r),!0).forEach((function(s){t()(o,s,r[s])})):Object.getOwnPropertyDescriptors?Object.defineProperties(o,Object.getOwnPropertyDescriptors(r)):O(Object(r)).forEach((function(s){Object.defineProperty(o,s,Object.getOwnPropertyDescriptor(r,s))}))}return o}var D,j={name:"ListaGrupoDeUsuarios",components:{ListaDeRegistros:m["a"]},data:function(){return{}},computed:A({},Object(c["b"])({getRegistros:"listaDeRegistros/getRegistros"})),methods:{atualizaLista:function(o){g["a"].atualizaLista({service:E,semRegistros:[{codigo:"Sem registros encontrados"}],self:this,done:o})}}},P=j,S=r("2877"),_=Object(S["a"])(P,p,n,!1,null,null,null),R=_.exports,z=r("b5ae"),L=function o(){U()(this,o),this.grupoUsuario=["abrir","inserir","alterar","excluir","relatorios"],this.usuario=["abrir","inserir","alterar","excluir","relatorios"],this.tipoDocumento=["abrir","inserir","alterar","excluir","relatorios"],this.tipoCorrespondencia=["abrir","inserir","alterar","excluir","relatorios"],this.tipoCobranca=["abrir","inserir","alterar","excluir","relatorios"],this.endereco=["abrir","inserir","alterar","excluir","relatorios"],this.rota=["abrir","inserir","alterar","excluir","relatorios"],this.setor=["abrir","inserir","alterar","excluir","relatorios"],this.protocoloEntrada=["abrir","inserir","alterar","excluir","relatorios"],this.malote=["abrir","inserir","alterar","excluir","relatorios"],this.maloteDocumento=["abrir","inserir","alterar","excluir","relatorios"],this.correspondencia=["abrir","inserir","alterar","excluir","relatorios"]},T=function o(){var s=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};U()(this,o),this.grupoUsuario=s.grupoUsuario||"",this.codigo=s.codigo||"",this.descricao=s.descricao||"",this.usuarioCriador=s.usuarioCriador||"",this.permissoes=s.permissoes||new L},B=r("b673"),H=r("de64"),I=r("99b66");function J(o,s){var r=Object.keys(o);if(Object.getOwnPropertySymbols){var e=Object.getOwnPropertySymbols(o);s&&(e=e.filter((function(s){return Object.getOwnPropertyDescriptor(o,s).enumerable}))),r.push.apply(r,e)}return r}function N(o){for(var s=1;s<arguments.length;s++){var r=null!=arguments[s]?arguments[s]:{};s%2?J(Object(r),!0).forEach((function(s){t()(o,s,r[s])})):Object.getOwnPropertyDescriptors?Object.defineProperties(o,Object.getOwnPropertyDescriptors(r)):J(Object(r)).forEach((function(s){Object.defineProperty(o,s,Object.getOwnPropertyDescriptor(r,s))}))}return o}var M={name:"Grupo-de-Usuarios",components:{BodyTabs:u["a"],ListaDeRegistros:R,BarraDeBotoes:l["a"]},data:function(){return{grupoUsuario:new T,errorCodigo:"Preencha o código do grupo",errorDescricao:"Preencha a descrição do grupo",permissoes:[],possoAlterarGrupoUsuario:!1,possoExcluirGrupoUsuario:!1}},validations:{grupoUsuario:{codigo:{required:z["required"],isUnique:function(o){var s=this,r=o;if(""===r)return this.errorCodigo="Preencha o código do grupo",!0;var e="gravar",a="";this.grupoUsuario.grupoUsuario&&(e="alterar",a=this.grupoUsuario.grupoUsuario);var i=Object(B["a"])("categoriasUsuarios","codigo",e,a,"categoriaUsuario",r).then((function(o){if(200===o.status)return!0===o.data.resposta||(s.errorCodigo="Este código já está em uso, escolha um diferente",!1)}));return i}},descricao:{required:z["required"]}}},methods:{reset:function(){this.$v.grupoUsuario.$reset(),this.grupoUsuario=new T,this.$router.push({name:"grupoUsuario"}),this.possoAlterarGrupoUsuario=!1,this.possoExcluirGrupoUsuario=!1},carrega:function(o){var s=this;console.log("vou carregar o grupoUsuario"),this.$q.loading.show({message:"Localizando o registro",messageColor:"white",spinnerSize:250,spinnerColor:"white"}),E.seleciona(o).then((function(o){s.$q.loading.hide(),console.log("peguei o grupoUsuario com sucesso"),s.grupoUsuario.codigo=o.data.codigo,s.grupoUsuario.descricao=o.data.descricao,s.grupoUsuario.grupoUsuario=o.data.grupoUsuario,s.grupoUsuario.usuarioCriador=o.data.usuarioCriador,s.grupoUsuario.permissoes=Object.assign({},s.grupoUsuario.permissoes,o.data.permissoes),console.log(s.grupoUsuario.permissoes.usuario),s.confereAlterarExcluir()}))},salvarAlterar:function(){var o=this;this.$q.loading.show({message:"Processando sua requisição",messageColor:"white",spinnerSize:250,spinnerColor:"white"}),clearTimeout(D),D=setTimeout((function(){if(o.$v.grupoUsuario.$touch(),o.$v.grupoUsuario.$error)return o.$q.loading.hide(),void o.$q.dialog({title:"Atenção",message:"Alguns campos precisam ser corrigidos."}).then((function(){})).catch((function(){}));o.grupoUsuario.grupoUsuario&&o.possoAlterarGrupoUsuario?(console.log("estou alterando o form"),E.altera(o.grupoUsuario).then((function(s){o.$q.loading.hide(),console.log("grupousuario alterado com sucesso"),o.$root.$emit("alteraUnicoRegistro",o.grupoUsuario),o.$q.notify({type:"positive",message:"Grupo de Usuário alterado com sucesso.",timeout:5e3}),o.getCategoriaUsuario===o.grupoUsuario.grupoUsuario&&o.$store.commit("login/setPermissoes",s.data.permissoes)}))):!o.grupoUsuario.grupoUsuario&&o.possoGravarGrupoUsuario?E.grava(o.grupoUsuario).then((function(s){console.log("grupoUsuario criado com sucesso"),o.grupoUsuario.grupoUsuario=s.data.grupoUsuario.grupoUsuario,o.grupoUsuario.usuarioCriador=s.data.grupoUsuario.usuarioCriador,o.$router.push("/grupousuarios/grupousuario/"+s.data.grupoUsuario.grupoUsuario),o.$q.notify({type:"positive",message:"Grupo de Usuários criado com sucesso.",timeout:5e3}),o.$root.$emit("adicionaRegistroNaLista",o.grupoUsuario),o.confereAlterarExcluir()})):I["a"].semPermissao()}),2e3)},excluir:function(){var o=this;this.possoExcluirGrupoUsuario?this.$q.dialog({title:"Tem certeza?",message:"Ao confirmar esta operação, não poderá desfazer.",ok:"Sim, excluir",cancel:"Cancelar"}).then((function(){o.$q.loading.show({message:"Processando sua requisição",messageColor:"white",spinnerSize:250,spinnerColor:"white"}),E.apaga(o.grupoUsuario.grupoUsuario).then((function(s){o.$q.loading.hide(),console.log("grupoUsuario removido com sucesso"),o.$q.notify({type:"negative",message:"Grupo de Usuário removido com sucesso.",timeout:5e3}),o.$root.$emit("removeRegistro",o.grupoUsuario.grupoUsuario),o.reset()}))})).catch((function(){})):I["a"].semPermissao()},confereAlterarExcluir:function(){this.possoAlterarGrupoUsuario=H["a"].alterar("grupoUsuario",this.grupoUsuario.usuarioCriador),this.possoExcluirGrupoUsuario=H["a"].excluir("grupoUsuario",this.grupoUsuario.usuarioCriador)}},props:{id:{}},watch:{id:function(o){o&&this.carrega(o)}},computed:N(N({},Object(c["b"])({getCategoriaUsuario:"login/getCategoriaUsuario"})),{},{possoGravarGrupoUsuario:function(){return H["a"].gravar("grupoUsuario")}})},F=M,K=(r("f9f8"),Object(S["a"])(F,e,a,!1,null,"7a4e0da9",null));s["default"]=K.exports},c9c9:function(o,s,r){},f9f8:function(o,s,r){"use strict";var e=r("c9c9"),a=r.n(e);a.a}}]);