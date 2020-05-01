import axios from 'axios';

export default {
	create = (name, description, type) => (
		axios.post("/apip/restaurants", {
			name: name,
			description: description,
			type: type
		});
	);

	findAll = () => (
		axios.get("/apip/restaurants");	
	);
}