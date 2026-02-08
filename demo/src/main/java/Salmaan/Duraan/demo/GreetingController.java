package Salmaan.Duraan.demo;

import lombok.*;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RestController;

import java.net.URI;

@RestController
public class GreetingController {
    @GetMapping("/")
    public String greeting() {
        return "Hello Java Spring Boot!";
    }

    @GetMapping("/greet/{name}")
    public String name(@PathVariable String name) {
        return " Hello," + name + "Yaasiin Mohamuud Abdullaahi";
    }
    @GetMapping("/success")
    public ResponseEntity<String> success() {
        return ResponseEntity.ok().header("message", "Operation is Sucessfully").body("Hello Spring Boot!");
    }
    @GetMapping("/not-found")
    public ResponseEntity<String> notFound() {
        return
                ResponseEntity.status(HttpStatus.NOT_FOUND).body("Not Found");
    }
    @PostMapping("/create")
    public ResponseEntity<String> create() {
        URI location = URI.create("http://localhost:8080/GreetingController/create");
        return ResponseEntity.created(location).body("Resource created");
    }

}



