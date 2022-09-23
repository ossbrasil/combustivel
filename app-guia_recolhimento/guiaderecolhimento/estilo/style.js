import { StyleSheet, Dimensions, SafeAreaView, PixelRatio } from 'react-native';

const { width: WIDTH } = Dimensions.get('window')

const { height: HEIGHT } = Dimensions.get('window')

const widthPercentageToDP = widthPercent => {
    const screenWidth = Dimensions.get('window').width;
    return PixelRatio.roundToNearestPixel(screenWidth * parseFloat(widthPercent) / 100);
};

const heightPercentageToDP = heightPercent => {
    const screenHeight = Dimensions.get('window').height;
    return PixelRatio.roundToNearestPixel(screenHeight * parseFloat(heightPercent) / 100);
};

export default styles = StyleSheet.create({
    //Estilo Home
    pesquisaHome: {
        color: '#000',
        width: widthPercentageToDP(90)
    },
    labelTxtLogin: {

        color: 'white',
        fontSize: 26,
    },
    labelLogin: {
        color: 'white',
    },
    inputLogin: {
        color: '#fff',
        flex: 1
    },
    arrumaInput: {

        width: widthPercentageToDP(90)
    },
    background: {
        flex: 1,
        justifyContent: "center",
        alignItems: "center",
    },

    btnLogin: {
        width: '30%',
        alignSelf: "center",
        marginTop: 30,
        borderColor: '#fff'
    },
    txtLogin: {
        flex: 1,
        alignContent: 'center',
        textAlign: 'center',
        color: '#fff'
    },
    //Estilo Global
    header: {
        backgroundColor: '#ff5c54',
    },
    footer: {
        backgroundColor: '#ff5c54'
    },
    footerIcons: {
        color: 'white',
    },
    container: {
        flex: 1,
        flexDirection: 'row',
        justifyContent: 'space-between'
    },
    containerBtn: {
        flex: 1,
        flexDirection: 'row',
        justifyContent: 'space-around',
    },
    col: {
        width: '50%',
        paddingBottom: 10,
    },
    centraliza: {
        flex: 1,
        width: '100%',
        height: '100%',
        justifyContent: "center",
        alignItems: "center",
        borderBottomColor: '#fff',
    },
    //Estilos componente Card Motorista
    card_motorista: {
        // height: heightPercentageToDP('28%'),
        width: widthPercentageToDP('85%'),
        backgroundColor: "#ffffff",
        borderRadius: 5,
        justifyContent: 'center',
        elevation: 5,
        padding: 10,
        margin: 10,
    },
    texto_motorista: {
        fontSize: 16,
    },
    //Estilo tela Home
    backgroundHome: {
        flex: 1,
        alignItems: "center",
        backgroundColor: 'white'
    },
    pickerAjudante: {
        width: widthPercentageToDP('85%'),
        borderRadius: 5,
        backgroundColor: "#ffffff",
        elevation: 5,
        margin: 10,
    },
    footer: {
        width: widthPercentageToDP('100%'),
        backgroundColor: '#ff5c54',

    },
    cardGuiaHome: {
        // height: heightPercentageToDP('40%'),
        width: widthPercentageToDP('90%'),
        backgroundColor: "#ffffff",
        borderRadius: 5,
        justifyContent: 'center',
        alignContent: 'center',
        elevation: 5,
        padding: 5,
        margin: 10,
    },
    //Estilos da pagina de Checklist
    backgroundChecklist: {
        flex: 1,
        alignItems: "center",
        backgroundColor: 'white',
    },
    rowChecklist: {
        flexDirection: 'row',
        // height: heightPercentageToDP('28%'),
        width: widthPercentageToDP('100%'),
        backgroundColor: "#ffffff",
        // borderRadius: 5,
        // justifyContent: 'center',
        elevation: 5,
        padding: 10,
        marginTop: 10
    },
    textChecklist: {
        fontSize: 18,
    },
    tituloChecklist: {
        padding: 5,
    },
    cardGuia: {
        height: heightPercentageToDP('68%'),
        width: widthPercentageToDP('90%'),
        backgroundColor: "#ffffff",
        borderRadius: 5,
        justifyContent: 'center',
        alignContent: 'center',
        elevation: 5,
    },
    btnServicos: {
        width: widthPercentageToDP('45%'),
        paddingTop: 10,
        paddingBottom: 10,
        alignItems: 'center',
        justifyContent: 'center',
    },
    backgroundHistorico: {
        flex: 1,
        alignItems: "center",
        justifyContent: 'center',
        backgroundColor: 'white',
    },
    lineHistorico: {
        backgroundColor: '#ff5c54',
        height: 1,
        width: '100%',
        opacity: 1,
    },
    lineCinza: {
        backgroundColor: '#D3D3D3',
        height: 1,
        width: '100%',
        opacity: 1
    },
    btn_sidebar: {
        flexDirection: 'row',
        alignItems: 'center',
        width: widthPercentageToDP('100%'),
        padding: 10,
        borderColor: '#D3D3D3',
        borderWidth: 1

    },
    txtbtn_sidebar: {
        fontSize: 20,
        paddingLeft: 10
    },
    card_infoFalecido: {
        // height: heightPercentageToDP('28%'),
        width: widthPercentageToDP('90%'),
        backgroundColor: "#ffffff",
        borderRadius: 5,
        justifyContent: 'center',
        elevation: 5,
        padding: 10,
        margin: 10,
    },
    text_note: {
        color: '#D3D3D3',
        fontSize: 14,
    },
    text_info: {
        fontSize: 16
    },
    text_title: {
        textAlign: 'center',
        fontSize: 18,
        padding: 5
    },
    input_guia: {
        borderWidth: 1.5,
        borderRadius: 5,
        // borderColor: '#D3D3D3',
        padding: 10,
        margin: 10,
    },
    btn_coleta: {
        width: widthPercentageToDP('80%'),
        backgroundColor: "#14733a",
        borderRadius: 5,
        justifyContent: 'center',
        elevation: 5,
        padding: 10,
        margin: 10,
    },
    txtbtn_coleta: {
        color: '#ffffff',
        fontSize: 18,
        textAlign: 'center',
    },
    menu: {
        flex: 1,
        width: window.width,
        height: window.height,
        backgroundColor: 'white',
        // padding: 20,
    },
    signature: {
        flex: 1,
        borderColor: '#000033',
        borderWidth: 1,
    },
    buttonStyle: {
        flex: 1, justifyContent: "center", alignItems: "center", height: 50,
        backgroundColor: "#eeeeee",
        margin: 10
    },
    card_placa: {
        // height: heightPercentageToDP('28%'),
        width: widthPercentageToDP('85%'),
        backgroundColor: "#ffffff",
        borderRadius: 5,
        justifyContent: 'center',
        elevation: 5,
        padding: 15,
        margin: 20,
    },
    texto_placa: {
        fontSize: 18,
    },
    texto_placa_titulo: {
        fontSize: 16,
        color: '#D3D3D3'
    },
    input_placa: {
        height: heightPercentageToDP('10%'),
        width: widthPercentageToDP('85%'),
        backgroundColor: "#ffffff",
        borderRadius: 5,
        justifyContent: 'center',
        elevation: 5,
        paddingLeft: 20,
        margin: 20,

    },
    cam_abastecimento: {
        flex: 1,
        justifyContent: 'flex-end',
        alignItems: 'center',
    },
    camera_abastecimento: {
        flex: 1,
        flexDirection: 'column',
        backgroundColor: 'black',
      },
      btn_abastecimento_cancel: {
        flex: 0,
        backgroundColor: '#fff',
        borderRadius: 5,
        padding: 15,
        paddingHorizontal: 20,
        alignSelf: 'center',
        margin: 20,
      },
      texto_btncapturar: {
        textAlign: 'center',
        fontSize: 26,
        marginLeft: 20,
      },
      card_foto: {
        height: heightPercentageToDP('40%'),
        width: widthPercentageToDP('70%'),
        backgroundColor: "#D3D3D3",
        borderRadius: 5,
        justifyContent: 'center',
        alignItems: 'center',
        alignSelf: 'center',
        elevation: 5,
        padding: 10,
        margin: 10,
    },
    texto_abastecimento: {
        fontSize: 18
    },
    btn_salvar: {
        flexDirection: 'row',
        width: widthPercentageToDP('80%'),
        backgroundColor: "#14733a",
        borderRadius: 5,
        justifyContent: 'center',
        alignSelf: 'center',
        elevation: 5,
        padding: 10,
        margin: 10,
    }

})


