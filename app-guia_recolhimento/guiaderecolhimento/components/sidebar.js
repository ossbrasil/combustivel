import React, { Component } from 'react';
import { View, Text, Alert, TouchableOpacity, Linking, ScrollView } from 'react-native';
import { Content } from 'native-base';
import styles from '../estilo/style'
import Icon from 'react-native-vector-icons/MaterialIcons'
import IconFont from 'react-native-vector-icons/FontAwesome'
import IconFont5 from 'react-native-vector-icons/FontAwesome5'
import IconIoni from 'react-native-vector-icons/Ionicons'
import IconMat from 'react-native-vector-icons/MaterialCommunityIcons'
import PropTypes from 'prop-types';

export default class Sidebar extends Component {

    constructor(props) {
        super(props);
        this.checklist = this.checklist.bind(this)
        this.historico = this.historico.bind(this)
        this.home = this.home.bind(this)
        this.abastecimento = this.abastecimento.bind(this)
        this.trocaplaca = this.trocaplaca.bind(this)
        // this.manuais = this.manuais.bind(this)
    }

    home() {
        this.props.navigation.navigate('Home');
    }

    checklist() {
        this.props.navigation.navigate('Checklist');
    }

    historico() {
        this.props.navigation.navigate('Historico');
    }

    abastecimento() {
        this.props.navigation.navigate('Abastecimento');
    }

    trocaplaca() {
        this.props.navigation.navigate('Trocaplaca');
    }

    render() {
        return (
            <ScrollView scrollsToTop={false} style={styles.menu}>
                {/* <Content style={{ backgroundColor: '#ffffff', flex: 1 }}> */}
                <View >
                    <TouchableOpacity style={styles.btn_sidebar} onPress={this.home}>
                        <IconFont5 name={'home'} size={40} color="black" style={{ padding: 5 }} />
                        <Text style={styles.txtbtn_sidebar}>Home</Text>
                    </TouchableOpacity>
                </View>
                <View >
                    <TouchableOpacity style={styles.btn_sidebar} onPress={this.historico}>
                        <IconFont5 name={'calendar-alt'} size={40} color="black" style={{ padding: 5 }} />
                        <Text style={styles.txtbtn_sidebar}>Histórico</Text>
                    </TouchableOpacity>
                </View>
                <View >
                    <TouchableOpacity style={styles.btn_sidebar} onPress={this.checklist}>
                        <IconFont name={'check-square-o'} size={40} color="black" style={{ padding: 5 }} />
                        <Text style={styles.txtbtn_sidebar}>Checklist</Text>
                    </TouchableOpacity>
                </View>
                <View >
                    <TouchableOpacity style={styles.btn_sidebar} onPress={this.abastecimento}>
                        <IconMat name={'gas-station'} size={40} color="black" style={{ padding: 5 }} />
                        <Text style={styles.txtbtn_sidebar}>Abastecimento</Text>
                    </TouchableOpacity>
                </View>
                <View >
                    <TouchableOpacity style={styles.btn_sidebar} onPress={this.trocaplaca}>
                        <IconMat name={'car-estate'} size={40} color="black" style={{ padding: 5 }} />
                        <Text style={styles.txtbtn_sidebar}>Troca de carro</Text>
                    </TouchableOpacity>
                </View>


                {/* </Content> */}
            </ScrollView>
        )
    }
}


// Sidebar.propTypes = {
//     onItemSelected: PropTypes.func.isRequired,
//   };