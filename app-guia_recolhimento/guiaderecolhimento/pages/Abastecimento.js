import * as React from 'react';
import { TouchableOpacity, BackHandler, View, Text, Alert, TextInput, ScrollView } from 'react-native';
import { Container, Content, Drawer } from 'native-base';
import styles from '../estilo/style'
import { RNCamera } from 'react-native-camera';
import AsyncStorage from '@react-native-community/async-storage';
import Sidebar from '../components/sidebar'
import Icon from 'react-native-vector-icons/Ionicons'
import Icone from 'react-native-vector-icons/FontAwesome5'
import api from '../services/api'


class Abastecimento extends React.PureComponent {
    constructor(props) {
        super(props);

        // this.camera = null;
        this.barcodeCodes = [];

        this.state = {

            cameraActivty: false,
            // qrCracha: '',
            selected: "0",
            carregando: 0,
            camera: {
                // type: RNCamera.Constants.Type.back,
                flashMode: RNCamera.Constants.FlashMode.auto,
            }
        }
        this.carrega_infos()
    }

    closeDrawer = () => {
        this.drawer._root.close()
      }
      openDrawer = () => {
        this.drawer._root.open()
      }

    carrega_infos = async () => {
        const dadosMot = await AsyncStorage.getItem('dadosMot')

        var jResponse = JSON.parse(dadosMot)

        var matricula = jResponse.matricula
        var nome = jResponse.nome
        var cnh = jResponse.cnh

        const infoCarro = await AsyncStorage.getItem('infoCarro')

        var jResponse = JSON.parse(infoCarro)

        var placa = jResponse.placa
        var modelo = jResponse.modelo
        var contrato = jResponse.contrato

        // Alert.alert("Teste", matricula)

        this.setState({
            matricula: matricula,
            nome: nome,
            cnh: cnh,
            placa: placa,
            modelo: modelo,
            contrato: contrato,
        })
    }

    onBarCodeRead(scanResult) {

        // Alert.alert("Teste", scanResult.type);

        if (scanResult.type == "QR_CODE" || scanResult.type == "UPC_E") {
            var array = scanResult.data.split("|")

            // this.setState({ cameraActivty: false })

            // // var teste = JSON.stringify(scanResult[0])

            // // Alert.alert("Teste", JSON.stringify(array))
            // // Alert.alert("Teste", array[0])


            let dia = array[1].toString().substr(6, 2)
            let mes = array[1].toString().substr(4, 2)
            let ano = array[1].toString().substr(0, 4)
            let hora = array[1].toString().substr(8, 2)
            let min = array[1].toString().substr(10, 2)
            let seg = array[1].toString().substr(12, 2)

            let data_ap = dia + '/' + mes + '/' + ano + '   ' + hora + ':' + min + ':' + seg
            let data = ano + '-' + mes + '-' + dia + ' ' + hora + ':' + min + ':' + seg

            let cnpj_1 = array[3].toString().substr(0, 2)
            let cnpj_2 = array[3].toString().substr(2, 3)
            let cnpj_3 = array[3].toString().substr(5, 3)
            let cnpj_4 = array[3].toString().substr(8, 4)
            let cnpj_5 = array[3].toString().substr(12, 2)

            let cnpj_ap = cnpj_1 + '.' + cnpj_2 + '.' + cnpj_3 + '/' + cnpj_4 + '-' + cnpj_5


            var str = array[0]

            str = str.replace(/\D/g, '')

            let cnpj_forn = str.toString().substr(6, 14)

            let cnpj_forn_1 = cnpj_forn.toString().substr(0, 2)
            let cnpj_forn_2 = cnpj_forn.toString().substr(2, 3)
            let cnpj_forn_3 = cnpj_forn.toString().substr(5, 3)
            let cnpj_forn_4 = cnpj_forn.toString().substr(8, 4)
            let cnpj_forn_5 = cnpj_forn.toString().substr(12, 2)

            let cnpj_forn_ap = cnpj_forn_1 + '.' + cnpj_forn_2 + '.' + cnpj_forn_3 + '/' + cnpj_forn_4 + '-' + cnpj_forn_5

            // Alert.alert("Teste", cnpj_forn)

            let cnpj = array[3]

            this.setState({
                cameraActivty: false,
                carregando: 1,
                data_ap: data_ap,
                data: data,
                valor: array[2],
                cnpj_ap: cnpj_ap,
                cnpj: cnpj,
                cnpj_forn_ap: cnpj_forn_ap,
                cnpj_forn: cnpj_forn,
            })
        } else {
            Alert.alert("Atenção", "Ocorreu um erro na leitura do QR code, por favor tente novamente!");
            this.setState({ cameraActivty: false })
        }
    }




    captura = async () => {
        this.setState({ cameraActivty: true })
    }

    cancel = async () => {
        this.setState({ cameraActivty: false })
    }

    salvar = async () => {
        try {
            const response = await api.post('/salvarAbastecimento/', {
                "matricula": this.state.matricula,
                "placa": this.state.placa,
                "data": this.state.data,
                "valor": this.state.valor,
                "cnpj": this.state.cnpj_forn_ap
            })

            Alert.alert("Atenção", "Registro salvo com sucesso!")

            this.setState({
                cameraActivty: false,
                carregando: 0,
                data_ap: '',
                data: '',
                valor: '',
                cnpj_ap: '',
                cnpj: '',
                cnpj_forn_ap: '',
                cnpj_forn: '',
            })

            // var jResponse = JSON.stringify(response.data)

            // Alert.alert("Teste", jResponse)
        } catch (error) {
            Alert.alert("Erro de conexão")
        }
    }


    //     render() {

    //         const menu = <Sidebar onItemSelected={this.onMenuItemSelected} />

    //         return (
    //             <SideMenu
    //                 menu={menu}
    //                 isOpen={this.state.isOpen}
    //                 onChange={isOpen => this.updateMenuState(isOpen)}
    //             >

    //                 <View style={styles.backgroundHistorico}>



    //                     <View style={{ flex: 1 }} />
    //                     <View style={styles.footer}>
    //                         <TouchableOpacity style={{ padding: 5 }}>
    //                             <Icon name={'menu'} size={40} color={'white'} onPress={isOpen => this.updateMenuState(isOpen)} />
    //                         </TouchableOpacity>
    //                     </View>
    //                 </View>
    //             </SideMenu>
    //         );
    //     }
    // }

    render() {

        if (this.state.cameraActivty) {
            return (


                <View style={styles.camera_abastecimento}>
                    <RNCamera
                        ref={ref => {
                            this.camera = ref;
                        }}
                        defaultTouchToFocus
                        flashMode={this.state.camera.flashMode}
                        mirrorImage={false}
                        onBarCodeRead={this.onBarCodeRead.bind(this)}
                        onFocusChanged={() => { }}
                        onZoomChanged={() => { }}
                        permissionDialogTitle={'Permission to use camera'}
                        permissionDialogMessage={'We need your permission to use your camera phone'}
                        // style={styles.preview}
                        style={styles.cam_abastecimento}
                        type={this.state.camera.type}
                    />
                    <View style={{ flex: 0, flexDirection: 'row', justifyContent: 'center' }}>
                        <TouchableOpacity onPress={this.cancel} style={styles.btn_abastecimento_cancel}>
                            <Text style={{ fontSize: 14 }}> Cancelar </Text>
                        </TouchableOpacity>
                    </View>
                </View>

            );
        } else {
            return (

                <Drawer
                    ref={(ref) => { this.drawer = ref; }}
                    content={<Sidebar navigation={this.props.navigation} />}
                    onClose={() => this.closeDrawer()}>

                    <ScrollView style={{ backgroundColor: 'white' }}>
                        <View style={styles.backgroundHome}>



                            {/* Tela antes do carregamento do QR Code */}
                            <View style={styles.background}>
                                <Text style={{ fontSize: 22, paddingTop: 20, paddingBottom: 20 }}>Captura do QR-code da nota fiscal</Text>

                                <View style={styles.card_motorista}>


                                    <View style={{ flexDirection: 'row', alignContent: 'center', justifyContent: 'center' }}>
                                        <Icon name={'camera'} size={40} color={"#ff5c54"} />
                                        <Icon name={'arrow-forward'} size={36} />
                                        <Icon name={'ios-qr-code'} size={40} color={"#ff5c54"} />
                                    </View>
                                    <View style={styles.card_foto}>
                                        <Icon name={'camera'} size={100} color={"#ff5c54"} />
                                    </View>
                                </View>


                                <View style={{ flex: 1 }}></View>
                                {/* <TouchableOpacity onPress={this.captura} style={styles.btn_coleta}>
                                    <Text style={styles.txtbtn_coleta}> Capturar </Text>
                                </TouchableOpacity> */}

                            </View>
                            {(this.state.carregando == 0) ?
                                <TouchableOpacity onPress={this.captura} style={styles.btn_coleta}>
                                    <Text style={styles.txtbtn_coleta}> Capturar </Text>
                                </TouchableOpacity>
                                :

                                // Tela após o carregamento do QR Code
                                <View style={styles.infoAbastecimento}>

                                    <View style={{ margin: 30 }}>
                                        <Text style={styles.texto_placa_titulo}>Motorista</Text>
                                        <Text style={styles.texto_abastecimento}>{this.state.nome}</Text>
                                        <Text style={styles.texto_placa_titulo}>Placa</Text>
                                        <Text style={styles.texto_abastecimento}>{this.state.placa}</Text>
                                        <Text style={styles.texto_placa_titulo}>Data e Hora</Text>
                                        <Text style={styles.texto_abastecimento}>{this.state.data_ap}</Text>
                                        <Text style={styles.texto_placa_titulo}>Valor</Text>
                                        <Text style={styles.texto_abastecimento}>R$ {this.state.valor}</Text>
                                        <Text style={styles.texto_placa_titulo}>CNPJ da empresa </Text>
                                        <Text style={styles.texto_abastecimento}>{this.state.cnpj_forn_ap}</Text>
                                    </View>


                                    <TouchableOpacity onPress={this.salvar} style={styles.btn_salvar}>
                                        <Icone name={'save'} size={24} color={"#ffffff"} style={{ marginRight: 10 }} />
                                        <Text style={styles.txtbtn_coleta}> Salvar </Text>
                                    </TouchableOpacity>

                                    <TouchableOpacity onPress={this.captura} style={styles.btn_coleta}>
                                        <Text style={styles.txtbtn_coleta}> Capturar novo</Text>
                                    </TouchableOpacity>

                                </View>
                            }
                        </View>
                    </ScrollView>
                    <View style={styles.footer}>
                        <TouchableOpacity style={{ padding: 5 }}>
                            <Icon name={'menu'} size={40} color={'white'} onPress={this.openDrawer} />
                        </TouchableOpacity>
                    </View>
                </Drawer >

            )
        }

    }
}

export default Abastecimento;