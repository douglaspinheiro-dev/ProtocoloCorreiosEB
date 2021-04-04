(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[13],{bebf:function(o,t,e){"use strict";e.r(t);var i=function(){var o=this,t=o.$createElement,e=o._self._c||t;return e("div",[e("bodyTabs",{attrs:{titulo:"Cadastro de Tipos de Documento"}},[e("template",{slot:"tabHeader"},[e("q-tab",{attrs:{name:"tab-1",icon:"folder_shared",label:"Cadastro"}})],1),e("template",{slot:"tabPanel"},[e("q-tab-panel",{attrs:{name:"tab-1"}},[e("form",{on:{submit:function(t){return t.preventDefault(),o.salvarAlterar(t)}}},[e("div",{staticClass:"row barraBotoes"},[e("div",{staticClass:"col-md-6 linhaBotoes"},[o.possoGravarTipoDocumento?e("q-btn",{attrs:{small:"",type:"reset",icon:"add"},on:{click:o.reset}},[o._v("Novo")]):o._e(),!o.tipoDocumento.tipoDocumento&&o.possoGravarTipoDocumento?e("q-btn",{attrs:{small:"",type:"submit",icon:"save"}},[o._v("Gravar")]):o._e(),o.tipoDocumento.tipoDocumento&&o.possoAlterarTipoDocumento?e("q-btn",{attrs:{small:"",type:"submit",icon:"save"}},[o._v("Alterar")]):o._e(),o.possoExcluirTipoDocumento?e("q-btn",{attrs:{small:"",type:"button",icon:"delete"},on:{click:o.excluir}},[o._v("Excluir")]):o._e()],1)]),e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-6"},[e("q-input",{staticClass:"form-input",attrs:{label:"Descrição",hint:"Obrigatório",error:o.$v.tipoDocumento.descricao.$error,"error-message":o.errorDescricao,autocomplete:"off",type:"text",name:"descricao"},on:{input:function(t){return o.$v.tipoDocumento.descricao.$touch()}},model:{value:o.tipoDocumento.descricao,callback:function(t){o.$set(o.tipoDocumento,"descricao",t)},expression:"tipoDocumento.descricao"}})],1),e("div",{staticClass:"col-md-3"},[e("q-input",{staticClass:"form-input",attrs:{label:"Código",hint:"Obrigatório",error:o.$v.tipoDocumento.codigo.$error,"error-message":"Obrigatório",autocomplete:"off",type:"text",name:"codigo"},on:{input:function(t){return o.$v.tipoDocumento.codigo.$touch()}},model:{value:o.tipoDocumento.codigo,callback:function(t){o.$set(o.tipoDocumento,"codigo",t)},expression:"tipoDocumento.codigo"}})],1),e("div",{staticClass:"col-md-3"},[e("q-field",{staticClass:"form-input",attrs:{label:"Status","stack-label":"",borderless:""}},[e("q-option-group",{attrs:{inline:"",options:[{label:"Ativo",value:1},{label:"Inativo",value:0}],color:"primary"},model:{value:o.tipoDocumento.status,callback:function(t){o.$set(o.tipoDocumento,"status",t)},expression:"tipoDocumento.status"}})],1)],1)])])])],1)],2),e("lista-de-registros")],1)},r=[],s=(e("f751"),e("bbff")),a=function(){var o=this,t=o.$createElement,e=o._self._c||t;return e("lista-de-registros",{ref:"listaDeRegistros",attrs:{labelHeader:"Tipos de Documentos"},on:{atualizaLista:o.atualizaLista}},[e("template",{slot:"qItem"},o._l(o.getRegistros,(function(t,i){return e("q-item",{key:i,staticClass:"item-lista",class:i%2?"bg-blue-grey-1":"bg-blue-grey-2",attrs:{multiline:"",item:"",to:{name:"alterarTipoDocumento",params:{id:t.tipoDocumento}},exact:""}},[e("q-item-section",[e("q-item-label",[o._v(" "+o._s(t.descricao))]),e("q-item-label",{attrs:{caption:""}},[o._v(o._s(t.codigo))])],1)],1)})),1)],2)},n=[],c=(e("8e6e"),e("8a81"),e("ac6a"),e("cadf"),e("06db"),e("456d"),e("9523")),u=e.n(c),l=e("2f62"),m=e("dbcf"),p=e("0da6"),d=(e("6b54"),e("2397"),e("970b")),D=e.n(d),f=e("5bc3"),g=e.n(f),v=e("ed6d"),b=e.n(v),h=e("6b58"),y=e.n(h),$=e("36c6"),q=e.n($),T=e("5c12");function w(o){var t=O();return function(){var e,i=q()(o);if(t){var r=q()(this).constructor;e=Reflect.construct(i,arguments,r)}else e=i.apply(this,arguments);return y()(this,e)}}function O(){if("undefined"===typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"===typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(o){return!1}}var C=function(o){b()(e,o);var t=w(e);function e(){return D()(this,e),t.apply(this,arguments)}return g()(e,null,[{key:"procura",value:function(o,t,e){return this.get("tipodocumentos",{params:{busca:o,inicio:t,fim:e}})}},{key:"grava",value:function(o){return this.post("tipodocumentos/tipodocumento",o)}},{key:"altera",value:function(o){return this.put("tipodocumentos/tipodocumento/".concat(o.tipoDocumento),o)}},{key:"apaga",value:function(o){return this.delete("tipodocumentos/tipodocumento/".concat(o))}},{key:"seleciona",value:function(o){return this.get("tipodocumentos/tipodocumento/".concat(o))}}]),e}(T["a"]),x=C;function _(o,t){var e=Object.keys(o);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(o);t&&(i=i.filter((function(t){return Object.getOwnPropertyDescriptor(o,t).enumerable}))),e.push.apply(e,i)}return e}function j(o){for(var t=1;t<arguments.length;t++){var e=null!=arguments[t]?arguments[t]:{};t%2?_(Object(e),!0).forEach((function(t){u()(o,t,e[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(o,Object.getOwnPropertyDescriptors(e)):_(Object(e)).forEach((function(t){Object.defineProperty(o,t,Object.getOwnPropertyDescriptor(e,t))}))}return o}var k={name:"ListaDeTipoDocumentos",components:{ListaDeRegistros:p["a"]},data:function(){return{}},computed:j({},Object(l["b"])({getRegistros:"listaDeRegistros/getRegistros"})),methods:{atualizaLista:function(o){m["a"].atualizaLista({service:x,semRegistros:[{descricao:"Sem registros encontrados",codigo:""}],self:this,done:o})}}},R=k,A=e("2877"),P=Object(A["a"])(R,a,n,!1,null,null,null),E=P.exports,z=e("b5ae"),L=e("540f"),S=e("b673"),G=e("de64"),B=e("99b66"),H={name:"Cadastro-de-TipoDocumentos",components:{BodyTabs:s["a"],ListaDeRegistros:E},data:function(){return{tipoDocumento:new L["a"],errorDescricao:"Preencha a descrição",possoAlterarTipoDocumento:!1,possoExcluirTipoDocumento:!1,timer:""}},validations:{tipoDocumento:{codigo:{required:z["required"]},descricao:{required:z["required"],isUnique:function(o){var t=this,e=o;if(""===e)return!0;var i="gravar",r="";this.tipoDocumento.tipoDocumento&&(i="alterar",r=this.tipoDocumento.tipoDocumento);var s=Object(S["a"])("categoriasDocumentos","descricao",i,r,"categoriaDocumento",e).then((function(o){if(200===o.status)return!0===o.data.resposta||(t.errorDescricao="Esta descrição ja está em, escolha outra",!1)}));return s}}}},methods:{reset:function(){this.$v.tipoDocumento.$reset(),this.tipoDocumento=new L["a"],this.$router.push({name:"tipoDocumento"}),this.possoAlterarTipoDocumento=!1,this.possoExcluirTipoDocumento=!1},carrega:function(o){var t=this;console.log("vou carregar o tipoDocumento"),this.$q.loading.show({message:"Localizando o registro",messageColor:"white",spinnerSize:250,spinnerColor:"white"}),x.seleciona(o).then((function(o){t.$q.loading.hide(),console.log("peguei o tipoDocumento com sucesso"),t.tipoDocumento=Object.assign({},t.tipoDocumento,o.data),t.confereAlterarExcluir()}))},salvarAlterar:function(){var o=this;this.$q.loading.show({message:"Processando sua requisição",messageColor:"white",spinnerSize:250,spinnerColor:"white"}),clearTimeout(this.timer),this.timer=setTimeout((function(){if(o.$v.tipoDocumento.$touch(),o.$v.tipoDocumento.$error)return o.$q.loading.hide(),void o.$q.dialog({title:"Atenção",message:"Alguns campos precisam ser corrigidos."});o.tipoDocumento.tipoDocumento&&o.possoAlterarTipoDocumento?(console.log("estou alterando o form"),x.altera(o.tipoDocumento).then((function(t){o.$q.loading.hide(),console.log("tipoDocumento alterado com sucesso"),o.$root.$emit("alteraUnicoRegistro",o.tipoDocumento),o.$q.notify({type:"positive",message:"Tipo de Documento alterado com sucesso.",timeout:5e3})}))):!o.tipoDocumento.tipoDocumento&&o.possoGravarTipoDocumento?x.grava(o.tipoDocumento).then((function(t){console.log("tipoDocumento criado com sucesso"),o.tipoDocumento.tipoDocumento=t.data.tipoDocumento.tipoDocumento,o.tipoDocumento.usuarioCriador=t.data.tipoDocumento.usuarioCriador,o.$router.push("/tipoDocumentos/tipoDocumento/"+t.data.tipoDocumento.tipoDocumento),o.$q.notify({type:"positive",message:"Tipo de Documento criado com sucesso.",timeout:5e3}),o.$root.$emit("adicionaRegistroNaLista",o.tipoDocumento),o.confereAlterarExcluir()})):B["a"].semPermissao()}),2e3)},excluir:function(){var o=this;this.possoExcluirTipoDocumento?this.$q.dialog({title:"Tem certeza?",message:"Ao confirmar esta operação, não poderá desfazer.",ok:"Sim, excluir",cancel:"Cancelar"}).onOk((function(){o.$q.loading.show({message:"Processando sua requisição",messageColor:"white",spinnerSize:250,spinnerColor:"white"}),x.apaga(o.tipoDocumento.tipoDocumento).then((function(t){o.$q.loading.hide(),console.log("tipoDocumento removido com sucesso"),o.$q.notify({type:"negative",message:"Tipo de Documento removido com sucesso.",timeout:5e3}),o.$root.$emit("removeRegistro",o.tipoDocumento.tipoDocumento),o.reset()}))})):B["a"].semPermissao()},confereAlterarExcluir:function(){this.possoAlterarTipoDocumento=G["a"].alterar("tipoDocumento",this.tipoDocumento.usuarioCriador),this.possoExcluirTipoDocumento=G["a"].excluir("tipoDocumento",this.tipoDocumento.usuarioCriador)}},props:{id:{}},watch:{"$route.params.id":{handler:function(o){o&&this.carrega(o)},deep:!0,immediate:!0}},computed:{possoGravarTipoDocumento:function(){return G["a"].gravar("tipoDocumento")}}},I=H,J=Object(A["a"])(I,i,r,!1,null,null,null);t["default"]=J.exports}}]);