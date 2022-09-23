import * as React from 'react';
import { TouchableOpacity, BackHandler, View, Text, Alert, TouchableHighlight, PermissionsAndroid } from 'react-native';
import styles from '../estilo/style'
import Icon from 'react-native-vector-icons/MaterialIcons'
import api from '../services/api'
import SignatureCapture from 'react-native-signature-capture';
import AsyncStorage from '@react-native-community/async-storage';


class Assinatura extends React.PureComponent {
    constructor(props) {
        super(props);
        this.state = {
            estado: 0,
        }

        this.checkAndroidPermission()
    }

    checkAndroidPermission = async () => {
        // const realm = await getRealm()
        //   await AsyncStorage.multiRemove(['allFotos'])

        if (Platform.OS === 'android') {
            try {

                // PermissionsAndroid.requestMultiple([PermissionsAndroid.PERMISSIONS.READ_EXTERNAL_STORAGE,PermissionsAndroid.PERMISSIONS.WRITE_EXTERNAL_STORAGE, PermissionsAndroid.PERMISSIONS.CAMERA])

                await PermissionsAndroid.request(PermissionsAndroid.PERMISSIONS.WRITE_EXTERNAL_STORAGE);
                // const permission = PermissionsAndroid.PERMISSIONS.WRITE_EXTERNAL_STORAGE;
                // await PermissionsAndroid.request(permission);

                await PermissionsAndroid.request(PermissionsAndroid.PERMISSIONS.CAMERA);
                // const permission2 = PermissionsAndroid.PERMISSIONS.CAMERA;
                // await PermissionsAndroid.request(permission2);

                await PermissionsAndroid.request(PermissionsAndroid.PERMISSIONS.READ_EXTERNAL_STORAGE);
                // const permission3 = PermissionsAndroid.PERMISSIONS.READ_EXTERNAL_STORAGE;
                // await PermissionsAndroid.request(permission3);

                Promise.resolve();
                // this.populaBanco()
            } catch (error) {
                Promise.reject(error);
            }
        }

    };

    saveSign = async () => {

        this.refs["sign"].saveImage();

        // Alert.alert("Teste")
        

    }

    resetSign() {
        this.refs["sign"].resetImage();
    }

    _onSaveEvent = async (result) =>  {
        // Alert.alert("lala", result.pathName)
        //result.encoded - for the base64 encoded png

        await AsyncStorage.setItem('assinaturaEncoded', result.encoded)
        //result.pathName - for the file path name
        console.log(result);
        this.props.navigation.navigate('Guiaservico');
    }
    _onDragEvent() {
        // This callback will be called when the user enters signature
        console.log("dragged");
    }

    render() {
        return (
            <View style={{ flex: 1 }}>
                <SignatureCapture
                    style={[{ flex: 1 }, styles.signature]}
                    ref="sign"
                    onSaveEvent={this._onSaveEvent}
                    onDragEvent={this._onDragEvent}
                    saveImageFileInExtStorage={false}
                    showNativeButtons={false}
                    showTitleLabel={false}
                    minStrokeWidth={4}
                    maxStrokeWidth={4}
                    viewMode={"portrait"} />

                <View style={{ flexDirection: "row", backgroundColor: 'white' }}>
                    <TouchableHighlight style={styles.buttonStyle}
                        onPress={() => { this.saveSign() }} >
                        <Text>Salvar</Text>
                    </TouchableHighlight>

                    <TouchableHighlight style={styles.buttonStyle}
                        onPress={() => { this.resetSign() }} >
                        <Text>Limpar</Text>
                    </TouchableHighlight>

                </View>
            </View>
        );

    }
}

export default Assinatura;
// AppRegistry.registerComponent('RNSignatureExample', () => RNSignatureExample);